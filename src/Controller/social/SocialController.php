<?php

namespace App\Controller\social;

use App\Entity\FeedPosts;
use App\Entity\GroupFeedPosts;
use App\Entity\GroupMembers;
use App\Entity\Likes;
use App\Entity\Comments;
use App\Entity\Shares;
use App\Entity\UserFollowers;
use App\Repository\FeedPostsRepository;
use App\Repository\GroupFeedPostsRepository;
use App\Repository\GroupMembersRepository;
use App\Repository\LikesRepository;
use App\Repository\CommentsRepository;
use App\Repository\UsersRepository;
use App\Repository\SharesRepository;
use App\Repository\UserGroupsRepository;
use App\Repository\UserFollowersRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/social')]
class SocialController extends AbstractController
{
    /**
     * Ajoute des variables globales à tous les templates
     */
    private function addGlobalVariables(EntityManagerInterface $entityManager): array
    {
        // Récupérer l'utilisateur connecté (exemple)
        $currentUser = $entityManager->getRepository(\App\Entity\Users::class)->find(1);
        
        // Récupérer le nombre de demandes de suivi en attente
        $pendingRequestsCount = 0;
        if ($currentUser) {
            $pendingRequestsCount = $entityManager->getRepository(\App\Entity\UserFollowers::class)->count([
                'followed' => $currentUser,
                'status' => \App\Entity\UserFollowers::STATUS_PENDING
            ]);
        }
        
        return [
            'pendingRequestsCount' => $pendingRequestsCount
        ];
    }
    #[Route('/', name: 'app_social')]
    public function index(
        FeedPostsRepository $feedPostsRepository,
        LikesRepository $likesRepository,
        CommentsRepository $commentsRepository,
        SharesRepository $sharesRepository,
        UsersRepository $usersRepository,
        EntityManagerInterface $entityManager
    ): Response {
        // Récupérer tous les posts
        $feedPosts = $feedPostsRepository->findBy(['isDeleted' => 0], ['timeStamp' => 'DESC']);
        $currentUser = $usersRepository->find(1); // Exemple d'utilisateur connecté
        $postsData = [];

        foreach ($feedPosts as $post) {
            $likes = $likesRepository->findBy(['postId' => $post]);
            $likeCount = count($likes);
            $userLiked = $likesRepository->findOneBy(['postId' => $post, 'user_id' => $currentUser]) !== null;
            $comments = $commentsRepository->findBy(['postId' => $post, 'isDeleted' => 0], ['timeStamp' => 'DESC']);

            $postsData[] = [
                'post' => $post,
                'user' => $post->getUserId(),
                'likeCount' => $likeCount,
                'comments' => $comments,
                'userLiked' => $userLiked,
            ];
        }

        $globalVars = $this->addGlobalVariables($entityManager);
        
        return $this->render('social/social.html.twig', array_merge([
            'posts' => $postsData,
        ], $globalVars));
    }

    #[Route('/add-post', name: 'app_social_add_post', methods: ['GET', 'POST'])]
    public function addPost(
        Request $request,
        EntityManagerInterface $entityManager,
        UsersRepository $usersRepository
    ): Response {
        if ($request->isMethod('POST')) {
            $user = $usersRepository->find(1); // Exemple d'utilisateur connecté
            if (!$user) {
                $this->addFlash('error', 'Utilisateur non trouvé');
                return $this->redirectToRoute('app_social');
            }

            $content = $request->request->get('content');
            $imageFile = $request->files->get('image_file');

            if (empty($content)) {
                $this->addFlash('error', 'Le contenu du post ne peut pas être vide');
                return $this->redirectToRoute('app_social');
            }

            $post = new FeedPosts();
            $post->setUserId($user);
            $post->setContent($content);
            $post->setTimeStamp((new \DateTime())->format('Y-m-d H:i:s'));       
            $post->setCreatedAt((new \DateTime())->format('Y-m-d H:i:s'));
            $post->setUpdatedAt((new \DateTime())->format('Y-m-d H:i:s'));
            $post->setScorePopularite(0);
            $post->setIsDeleted(0);

            if ($imageFile) {
                $uploadsDirectory = $this->getParameter('kernel.project_dir') . '/public/uploads/images';
                $newFilename = uniqid() . '.' . $imageFile->guessExtension();
                $imageFile->move($uploadsDirectory, $newFilename);
                $post->setImagePath('/uploads/images/' . $newFilename);
            }

            $entityManager->persist($post);
            $entityManager->flush();

            $this->addFlash('success', 'Post ajouté avec succès');
            return $this->redirectToRoute('app_social');
        }

        return $this->render('social/add_post.html.twig');
    }

    #[Route('/like/{id}', name: 'app_social_like_post', methods: ['POST'])]
    public function likePost(
        Request $request,
        FeedPostsRepository $feedPostsRepository,
        LikesRepository $likesRepository,
        EntityManagerInterface $entityManager,
        UsersRepository $usersRepository
    ): Response {
        $postId = $request->attributes->get('id');
        $post = $feedPostsRepository->find($postId);
        
        if (!$post) {
            $this->addFlash('error', 'Post non trouvé');
            return $this->redirectToRoute('app_social');
        }
        
        $currentUser = $usersRepository->find(1); // Exemple d'utilisateur connecté
        if (!$currentUser) {
            $this->addFlash('error', 'Utilisateur non trouvé');
            return $this->redirectToRoute('app_social');
        }

        $existingLike = $likesRepository->findOneBy(['postId' => $post, 'user_id' => $currentUser]);
        if ($existingLike) {
            $entityManager->remove($existingLike);
            $this->addFlash('success', 'Vous avez retiré votre like');
        } else {
            $like = new Likes();
            $like->setPostId($post);
            $like->setUserId($currentUser);
            $like->setTimeStamp((new \DateTime())->format('Y-m-d H:i:s'));
            $entityManager->persist($like);
            $this->addFlash('success', 'Vous avez aimé ce post');
        }

        $entityManager->flush();
        return $this->redirectToRoute('app_social');
    }

    #[Route('/comment/{id}', name: 'app_social_add_comment', methods: ['POST'])]
    public function addComment(
        Request $request,
        FeedPostsRepository $feedPostsRepository,
        EntityManagerInterface $entityManager,
        UsersRepository $usersRepository
    ): Response {
        $postId = $request->attributes->get('id');
        $post = $feedPostsRepository->find($postId);
        
        if (!$post) {
            $this->addFlash('error', 'Post non trouvé');
            return $this->redirectToRoute('app_social');
        }
        $currentUser = $usersRepository->find(1); // Exemple d'utilisateur connecté
        if (!$currentUser) {
            $this->addFlash('error', 'Utilisateur non trouvé');
            return $this->redirectToRoute('app_social');
        }

        $content = $request->request->get('content');
        if (empty($content)) {
            $this->addFlash('error', 'Le commentaire ne peut pas être vide');
            return $this->redirectToRoute('app_social');
        }

        $comment = new Comments();
        $comment->setPostId($post);
        $comment->setUserId($currentUser);
        $comment->setContent($content);
        $comment->setTimeStamp((new \DateTime())->format('Y-m-d H:i:s'));
        $comment->setIsDeleted(0);

        $entityManager->persist($comment);
        $entityManager->flush();

        $this->addFlash('success', 'Commentaire ajouté avec succès');
        return $this->redirectToRoute('app_social');
    }
    
   

    /**
     * Recherche des utilisateurs et des groupes
     */
    #[Route('/search', name: 'app_social_search', methods: ['GET'])]
    public function search(
        Request $request,
        UsersRepository $usersRepository,
        UserGroupsRepository $userGroupsRepository
    ): Response {
        $searchTerm = $request->query->get('search', '');
        
        if (empty($searchTerm)) {
            return $this->render('social/search_results.html.twig', [
                'results' => ['searchTerm' => $searchTerm]
            ]);
        }
        
        $users = $usersRepository->searchUsers($searchTerm);
        $groups = $userGroupsRepository->searchGroups($searchTerm);
        
        return $this->render('social/search_results.html.twig', [
            'results' => [
                'searchTerm' => $searchTerm,
                'users' => $users,
                'groups' => $groups
            ]
        ]);
    }
    
    /**
     * Recherche AJAX pour l'autocomplétion (sans API)
     */
    #[Route('/search-ajax', name: 'app_social_search_ajax', methods: ['GET'])]
    public function searchAjax(
        Request $request,
        UsersRepository $usersRepository,
        UserGroupsRepository $userGroupsRepository
    ): JsonResponse {
        $searchTerm = $request->query->get('search', '');
        $results = [];
        
        if (strlen($searchTerm) >= 2) {
            $users = $usersRepository->searchUsers($searchTerm);
            $groups = $userGroupsRepository->searchGroups($searchTerm);
            
            foreach ($users as $user) {
                $results['users'][] = [
                    'id' => $user->getId(),
                    'username' => $user->getUsername(),
                    'email' => $user->getEmail(),
                    'type' => 'user'
                ];
            }
            
            foreach ($groups as $group) {
                $results['groups'][] = [
                    'id' => $group->getId(),
                    'name' => $group->getName(),
                    'description' => $group->getDescription() ?? '',
                    'type' => 'group'
                ];
            }
        }
        
        return new JsonResponse($results);
    }

    /**
     * Affiche un post individuel (nécessaire pour le partage)
     */
    #[Route('/post/{id}', name: 'app_social_view_post')]
    public function viewPost(
        int $id,
        FeedPostsRepository $feedPostsRepository,
        LikesRepository $likesRepository,
        CommentsRepository $commentsRepository,
        SharesRepository $sharesRepository,
        UsersRepository $usersRepository
    ): Response {
        $post = $feedPostsRepository->find($id);
        
        if (!$post || $post->getIsDeleted()) {
            $this->addFlash('error', 'Post non trouvé');
            return $this->redirectToRoute('app_social');
        }
        
        $currentUser = $usersRepository->find(1); // Exemple d'utilisateur connecté
        
        $likes = $likesRepository->findBy(['postId' => $post]);
        $likeCount = count($likes);
        $userLiked = $likesRepository->findOneBy(['postId' => $post, 'user_id' => $currentUser]) !== null;
        $comments = $commentsRepository->findBy(['postId' => $post, 'isDeleted' => 0], ['timeStamp' => 'DESC']);
        $shares = $sharesRepository->findBy(['postId' => $post]);
        $shareCount = count($shares);
        $userShared = $sharesRepository->findOneBy(['postId' => $post, 'user_id' => $currentUser]) !== null;
        
        $postData = [
            'post' => $post,
            'user' => $post->getUserId(),
            'likeCount' => $likeCount,
            'comments' => $comments,
            'userLiked' => $userLiked,
            'shareCount' => $shareCount,
            'userShared' => $userShared,
        ];
        
        return $this->render('social/view_post.html.twig', [
            'posts' => [$postData],
        ]);
    }
    
    // La méthode de partage interne a été supprimée
    // Seul le partage externe sur les réseaux sociaux est maintenant disponible
    
    /**
     * Affiche le profil d'un utilisateur avec ses publications
     */
    #[Route('/user/{id}', name: 'app_social_user_profile')]
    public function userProfile(
        int $id,
        UsersRepository $usersRepository,
        FeedPostsRepository $feedPostsRepository,
        LikesRepository $likesRepository,
        CommentsRepository $commentsRepository
    ): Response {
        $user = $usersRepository->find($id);
        
        if (!$user) {
            $this->addFlash('error', 'Utilisateur non trouvé');
            return $this->redirectToRoute('app_social');
        }
        
        // Récupérer les publications de l'utilisateur
        $userPosts = $feedPostsRepository->findBy(['userId' => $user, 'isDeleted' => 0], ['timeStamp' => 'DESC']);
        $currentUser = $usersRepository->find(1); // Exemple d'utilisateur connecté
        $postsData = [];
        
        foreach ($userPosts as $post) {
            $likes = $likesRepository->findBy(['postId' => $post]);
            $likeCount = count($likes);
            $userLiked = $likesRepository->findOneBy(['postId' => $post, 'user_id' => $currentUser]) !== null;
            $comments = $commentsRepository->findBy(['postId' => $post, 'isDeleted' => 0], ['timeStamp' => 'DESC']);
            
            $postsData[] = [
                'post' => $post,
                'user' => $post->getUserId(),
                'likeCount' => $likeCount,
                'comments' => $comments,
                'userLiked' => $userLiked,
            ];
        }
        
        return $this->render('social/user_profile.html.twig', [
            'user' => $user,
            'posts' => $postsData,
        ]);
    }
    
    /**
     * Affiche le profil d'un groupe avec ses publications
     */
    #[Route('/group/{id}', name: 'app_social_group_profile')]
    public function groupProfile(
        int $id,
        UserGroupsRepository $userGroupsRepository,
        GroupFeedPostsRepository $groupFeedPostsRepository,
        UsersRepository $usersRepository,
        LikesRepository $likesRepository,
        CommentsRepository $commentsRepository
    ): Response {
        $group = $userGroupsRepository->find($id);
        
        if (!$group) {
            $this->addFlash('error', 'Groupe non trouvé');
            return $this->redirectToRoute('app_social');
        }
        
        // Récupérer les publications du groupe
        $groupPosts = $groupFeedPostsRepository->findBy(['group' => $group, 'is_deleted' => 0], ['timestamp' => 'DESC']);
        $currentUser = $usersRepository->find(1); // Exemple d'utilisateur connecté
        $postsData = [];
        
        foreach ($groupPosts as $post) {
            $likes = $likesRepository->findBy(['postId' => $post]);
            $likeCount = count($likes);
            $userLiked = $likesRepository->findOneBy(['postId' => $post, 'user_id' => $currentUser]) !== null;
            $comments = $commentsRepository->findBy(['postId' => $post, 'isDeleted' => 0], ['timeStamp' => 'DESC']);
            
            $postsData[] = [
                'post' => $post,
                'user' => $post->getUserId(),
                'likeCount' => $likeCount,
                'comments' => $comments,
                'userLiked' => $userLiked,
            ];
        }
        
        return $this->render('social/group_profile.html.twig', [
            'group' => $group,
            'posts' => $postsData,
        ]);
    }
    
    /**
     * Ajoute un post dans un groupe
     */
    #[Route('/group/{id}/add-post', name: 'app_social_group_add_post', methods: ['POST'])]
    public function addGroupPost(
        int $id,
        Request $request,
        EntityManagerInterface $entityManager,
        UserGroupsRepository $userGroupsRepository,
        UsersRepository $usersRepository
    ): Response {
        $group = $userGroupsRepository->find($id);
        
        if (!$group) {
            $this->addFlash('error', 'Groupe non trouvé');
            return $this->redirectToRoute('app_social');
        }
        
        $user = $usersRepository->find(1); // Exemple d'utilisateur connecté
        if (!$user) {
            $this->addFlash('error', 'Utilisateur non trouvé');
            return $this->redirectToRoute('app_social_group_profile', ['id' => $id]);
        }

        $content = $request->request->get('content');
        $imageFile = $request->files->get('image_file');

        if (empty($content)) {
            $this->addFlash('error', 'Le contenu du post ne peut pas être vide');
            return $this->redirectToRoute('app_social_group_profile', ['id' => $id]);
        }

        $post = new GroupFeedPosts();
        $post->setGroupId($group);
        $post->setUserId($user);
        $post->setContent($content);
        $post->setTimestamp((new \DateTime())->format('Y-m-d H:i:s'));
        $post->setIsDeleted(0);

        if ($imageFile) {
            $uploadsDirectory = $this->getParameter('kernel.project_dir') . '/public/uploads/images';
            $newFilename = uniqid() . '.' . $imageFile->guessExtension();
            $imageFile->move($uploadsDirectory, $newFilename);
            $post->setMediaUrl('/uploads/images/' . $newFilename);
        } else {
            $post->setMediaUrl('');
        }

        $entityManager->persist($post);
        $entityManager->flush();

        $this->addFlash('success', 'Post ajouté au groupe avec succès');
        return $this->redirectToRoute('app_social_group_profile', ['id' => $id]);
    }
    
    /**
     * Permet à un utilisateur de rejoindre un groupe
     */
    #[Route('/group/{id}/join', name: 'app_social_join_group', methods: ['POST'])]
    public function joinGroup(
        int $id,
        Request $request,
        EntityManagerInterface $entityManager,
        UserGroupsRepository $userGroupsRepository,
        UsersRepository $usersRepository,
        GroupMembersRepository $groupMembersRepository
    ): Response {
        $group = $userGroupsRepository->find($id);
        
        if (!$group) {
            $this->addFlash('error', 'Groupe non trouvé');
            return $this->redirectToRoute('app_social');
        }
        
        $user = $usersRepository->find(1); // Exemple d'utilisateur connecté
        if (!$user) {
            $this->addFlash('error', 'Utilisateur non trouvé');
            return $this->redirectToRoute('app_social_group_profile', ['id' => $id]);
        }

        // Vérifier si l'utilisateur est déjà membre du groupe
        $existingMembership = $groupMembersRepository->findOneBy(['group' => $group, 'user_id' => $user]);
        if ($existingMembership) {
            $this->addFlash('info', 'Vous êtes déjà membre de ce groupe');
            return $this->redirectToRoute('app_social_group_profile', ['id' => $id]);
        }

        // Ajouter l'utilisateur comme membre du groupe
        $membership = new GroupMembers();
        $membership->setGroupIt($group);
        $membership->setUserId($user);
        $membership->setRole('member'); // Rôle par défaut

        $entityManager->persist($membership);
        $entityManager->flush();

        $this->addFlash('success', 'Vous avez rejoint le groupe avec succès');
        return $this->redirectToRoute('app_social_group_profile', ['id' => $id]);
    }
    
    /**
     * Permet à un utilisateur d'envoyer une demande pour suivre un autre utilisateur
     */
    #[Route('/user/{id}/follow', name: 'app_social_follow_user', methods: ['POST'])]
    public function followUser(
        int $id,
        Request $request,
        EntityManagerInterface $entityManager,
        UsersRepository $usersRepository,
        UserFollowersRepository $userFollowersRepository
    ): Response {
        $userToFollow = $usersRepository->find($id);
        
        if (!$userToFollow) {
            $this->addFlash('error', 'Utilisateur non trouvé');
            return $this->redirectToRoute('app_social');
        }
        
        $currentUser = $usersRepository->find(1); // Exemple d'utilisateur connecté
        if (!$currentUser) {
            $this->addFlash('error', 'Utilisateur non connecté');
            return $this->redirectToRoute('app_social_user_profile', ['id' => $id]);
        }

        // Vérifier si l'utilisateur se suit lui-même
        if ($currentUser->getId() === $userToFollow->getId()) {
            $this->addFlash('error', 'Vous ne pouvez pas vous suivre vous-même');
            return $this->redirectToRoute('app_social_user_profile', ['id' => $id]);
        }

        // Vérifier si l'utilisateur suit déjà cet utilisateur ou a une demande en cours
        $existingFollow = $userFollowersRepository->findOneBy(['follower' => $currentUser, 'followed' => $userToFollow]);
        if ($existingFollow) {
            // Si déjà suivi ou demande en cours, on annule
            $entityManager->remove($existingFollow);
            $entityManager->flush();
            
            if ($existingFollow->isAccepted()) {
                $this->addFlash('success', 'Vous ne suivez plus cet utilisateur');
            } else if ($existingFollow->isPending()) {
                $this->addFlash('success', 'Votre demande a été annulée');
            }
        } else {
            // Sinon, on crée une demande en attente
            $follow = new UserFollowers();
            $follow->setFollower($currentUser);
            $follow->setFollowed($userToFollow);
            $follow->setCreatedAt((new \DateTime())->format('Y-m-d H:i:s'));
            $follow->setStatus(UserFollowers::STATUS_PENDING);
            
            $entityManager->persist($follow);
            $entityManager->flush();
            $this->addFlash('success', 'Votre demande pour suivre cet utilisateur a été envoyée');
        }

        return $this->redirectToRoute('app_social_user_profile', ['id' => $id]);
    }
    
    /**
     * Permet à un utilisateur d'accepter ou de refuser une demande de suivi
     */
    #[Route('/follow-request/{id}/{action}', name: 'app_social_follow_request', methods: ['GET', 'POST'])]
    public function handleFollowRequest(
        int $id,
        string $action,
        Request $request,
        EntityManagerInterface $entityManager,
        UserFollowersRepository $userFollowersRepository,
        UsersRepository $usersRepository
    ): Response {
        $followRequest = $userFollowersRepository->find($id);
        
        if (!$followRequest) {
            $this->addFlash('error', 'Demande non trouvée');
            return $this->redirectToRoute('app_social');
        }
        
        $currentUser = $usersRepository->find(1); // Exemple d'utilisateur connecté
        if (!$currentUser) {
            $this->addFlash('error', 'Utilisateur non connecté');
            return $this->redirectToRoute('app_social');
        }
        
        // Vérifier que la demande concerne bien l'utilisateur connecté
        if ($followRequest->getFollowed()->getId() !== $currentUser->getId()) {
            $this->addFlash('error', 'Vous n\'êtes pas autorisé à gérer cette demande');
            return $this->redirectToRoute('app_social');
        }
        
        // Vérifier que la demande est en attente
        if (!$followRequest->isPending()) {
            $this->addFlash('error', 'Cette demande a déjà été traitée');
            return $this->redirectToRoute('app_social');
        }
        
        if ($action === 'accept') {
            $followRequest->setStatus(UserFollowers::STATUS_ACCEPTED);
            $entityManager->flush();
            $this->addFlash('success', 'Vous avez accepté la demande de suivi');
        } else if ($action === 'reject') {
            $followRequest->setStatus(UserFollowers::STATUS_REJECTED);
            $entityManager->flush();
            $this->addFlash('success', 'Vous avez refusé la demande de suivi');
        } else {
            $this->addFlash('error', 'Action non reconnue');
        }
        
        return $this->redirectToRoute('app_social');
    }
    
    /**
     * Affiche les demandes de suivi en attente pour l'utilisateur connecté
     */
    #[Route('/follow-requests', name: 'app_social_follow_requests')]
    public function followRequests(
        Request $request,
        UserFollowersRepository $userFollowersRepository,
        UsersRepository $usersRepository,
        EntityManagerInterface $entityManager
    ): Response {
        $currentUser = $usersRepository->find(1); // Exemple d'utilisateur connecté
        if (!$currentUser) {
            $this->addFlash('error', 'Utilisateur non connecté');
            return $this->redirectToRoute('app_social');
        }
        
        // Récupérer les demandes en attente
        $pendingRequests = $userFollowersRepository->findBy([
            'followed' => $currentUser,
            'status' => \App\Entity\UserFollowers::STATUS_PENDING
        ]);
        
        $globalVars = $this->addGlobalVariables($entityManager);
        
        return $this->render('social/follow_requests.html.twig', array_merge([
            'pendingRequests' => $pendingRequests
        ], $globalVars));
    }
}