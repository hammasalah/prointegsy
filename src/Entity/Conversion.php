<?php

namespace App\Command;

use App\Entity\Conversion;
use App\Entity\Users;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:test-conversion')]
class TestConversionCommand extends Command
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
    }

    protected function configure(): void
    {
        $this->setDescription('Test the creation of a Conversion entity.');
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

        // Créer une conversion
        $conversion = new Conversion();
        $conversion->setUserId($user);
        $conversion->setPointsConvertis(500);
        $conversion->setMontant('50.00');
        $conversion->setDevise('TND');
        $conversion->setDate(new \DateTime());

        $this->entityManager->persist($conversion);
        $this->entityManager->flush();

        $output->writeln('Conversion created successfully! ID: ' . $conversion->getId());

        return Command::SUCCESS;
    }
}    

// Compare this snippet from prointegsy/src/Entity/Users.php: