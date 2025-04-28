<?php

namespace App\Command;

use App\Entity\Users;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:test-users')]
class TestUsersCommand extends Command
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
    }

    protected function configure(): void
    {
        $this->setDescription('Test the creation of a Users entity.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // Créer un utilisateur de test
        $user = new Users();
        $user->setUsername('testuser');
        $user->setEmail('test@example.com');
        $user->setPassword('testpassword');
        $user->setCreatedAt((new \DateTime())->format('Y-m-d H:i:s'));
        $user->setUpdatedAt((new \DateTime())->format('Y-m-d H:i:s'));
        $user->setPoints(1000);
        $user->setAge(30);
        $user->setGender('male');
        $user->setArgent('50.00');

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $output->writeln('User created successfully! ID: ' . $user->getId());

        return Command::SUCCESS;
    }
}