<?php

namespace App\Command;

use App\Entity\Participation;
use App\Entity\Users;
use App\Entity\Events;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:test-participation')]
class TestParticipationCommand extends Command
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
    }

    protected function configure(): void
    {
        $this->setDescription('Test the creation of a Participation entity.');
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

        // Créer un événement de test si nécessaire
        $event = $this->entityManager->getRepository(Events::class)->find(1);
        if (!$event) {
            $event = new Events();
            $event->setTitle('Test Event');
            $event->setOrganizerId($user);
            $this->entityManager->persist($event);
        }

        // Créer une participation
        $participation = new Participation();
        $participation->setEvent($event);
        $participation->setParticipant($user);

        $this->entityManager->persist($participation);
        $this->entityManager->flush();

        $output->writeln('Participation created successfully! ID: ' . $participation->getId());

        return Command::SUCCESS;
    }
}

// Compare this snippet from prointegsy/src/Entity/Users.php: