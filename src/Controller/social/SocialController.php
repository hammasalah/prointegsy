<?php

namespace App\Controller\social;

use App\Entity\FeedPosts;
use App\Entity\Likes;
use App\Entity\Comments;
use App\Repository\FeedPostsRepository;
use App\Repository\LikesRepository;
use App\Repository\CommentsRepository;
use App\Repository\UsersRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
            $comments = $commentsRepository->findBy(['postId' => $post, 'isDeleted' => null], ['timeStamp' => 'DESC'], 3);

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
        FeedPosts $post,
        LikesRepository $likesRepository,
        EntityManagerInterface $entityManager,
        UsersRepository $usersRepository
    ): Response {
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
            $entityManager->persist($like);
            $this->addFlash('success', 'Vous avez aimé ce post');
        }

        $entityManager->flush();
        return $this->redirectToRoute('app_social');
    }

    #[Route('/comment/{id}', name: 'app_social_add_comment', methods: ['POST'])]
    public function addComment(
        FeedPosts $post,
        Request $request,
        EntityManagerInterface $entityManager,
        UsersRepository $usersRepository
    ): Response {
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
}