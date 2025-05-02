<?php

namespace App\Controller\social;

use App\Entity\FeedPosts;
use App\Entity\GroupFeedPosts;
use App\Entity\Likes;
use App\Entity\Comments;
use App\Entity\Shares;
use App\Repository\FeedPostsRepository;
use App\Repository\GroupFeedPostsRepository;
use App\Repository\LikesRepository;
use App\Repository\CommentsRepository;
use App\Repository\UsersRepository;
use App\Repository\SharesRepository;
use App\Repository\UserGroupsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/social')]
class SocialController extends AbstractController
{
    #[Route('/', name: 'app_social')]
    public function index(
        FeedPostsRepository $feedPostsRepository,
        LikesRepository $likesRepository,
        CommentsRepository $commentsRepository,
        SharesRepository $sharesRepository,
        UsersRepository $usersRepository
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

        return $this->render('social/social.html.twig', [
            'posts' => $postsData,
        ]);
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
}