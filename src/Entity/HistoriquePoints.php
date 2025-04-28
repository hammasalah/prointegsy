<?php

namespace App\Command;

use App\Entity\HistoriquePoints;
use App\Entity\Users;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:test-historique-points')]
class TestHistoriquePointsCommand extends Command
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
    }

    protected function configure(): void
    {
        $this->setDescription('Test the creation of a HistoriquePoints entity.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // Créer un utilisateur de test si nécessaire
        $user = $this->entityManager->getRepository(Users::class)->find(1);
        if (!$user) {
            $user = new Users();
            $user->setUsername('testuser');
            $user->setEmail('test@example.com');
            $user->setPassword('testpassword');
            $user->setCreatedAt((new \DateTime())->format('Y-m-d H:i:s'));
            $user->setUpdatedAt((new \DateTime())->format('Y-m-d H:i:s'));
            $user->setPoints(1000);
            $user->setAge(30);
            $user->setGender('male');
            $user->setArgent('0.00');
            $this->entityManager->persist($user);
        }

        // Créer une entrée dans historique_points
        $historiquePoints = new HistoriquePoints();
        $historiquePoints->setUserId($user);
        $historiquePoints->setType('gain');
        $historiquePoints->setPoints(100);
        $historiquePoints->setRaison('Test gain');
        $historiquePoints->setDate(new \DateTime());

        $this->entityManager->persist($historiquePoints);
        $this->entityManager->flush();

        $output->writeln('HistoriquePoints created successfully! ID: ' . $historiquePoints->getId());

        return Command::SUCCESS;
    }
}
    