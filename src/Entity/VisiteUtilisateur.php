<?php
namespace App\Controller;

use App\Entity\UserRewards;
use App\Entity\User;
use App\Entity\Reward;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{
    #[Route('/test/user-reward', name: 'test_user_reward')]
    public function test(EntityManagerInterface $em): Response
    {
        $user = $em->getRepository(User::class)->find(1); // Exemple
        $reward = $em->getRepository(Reward::class)->find(1); // Exemple

        $userReward = new UserRewards();
        $userReward->setUser($user);
        $userReward->setReward($reward);
        $userReward->setPointsEarned(100);
        $userReward->setEarnedAt((new \DateTime())->format('Y-m-d H:i:s'));

        $em->persist($userReward);
        $em->flush();

        return new Response('UserReward créé !');
    }
}

// Compare this snippet from prointegsy/src/Entity/Users.php: