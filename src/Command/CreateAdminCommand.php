<?php

namespace App\Command;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:create-admin',
    description: 'Créer un administrateur',
)]
class CreateAdminCommand extends Command
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct('app:create-admin');

        $this->entityManager = $entityManager;
    }
    
    protected function configure(): void
    {
        $this
            ->addArgument('username', InputArgument::OPTIONAL, 'Username')
            ->addArgument('password', InputArgument::OPTIONAL, 'Password')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $helper = $this->getHelper('question');
        $io = new SymfonyStyle($input, $output);

        $username = $input->getArgument('username');
        if (!$username) {
            $question = new Question('tapez votre nom d\'utilisateur : ');
            $username = $helper->ask($input, $output, $question);
        }

        $plainPassword = $input->getArgument('password');
        if (!$plainPassword) {
            $question = new Question('Tapez votre mot de passe : ');
            $question->setHidden(true);
            $question->setHiddenFallback(false);
            $plainPassword = $helper->ask($input, $output, $question);
        }

        $user = (new User())
            ->setUsername($username)
            ->setPlainPassword($plainPassword)
            ->setRoles(['ROLE_ADMIN']);

        $existingUser = $this->entityManager->getRepository(User::class)->findOneBy(['username' => $username]);

        if ($existingUser) {
            $io->warning('Ce nom d\'utilisateur est déjà pris.');
            return Command::FAILURE;
        } else {
            $this->entityManager->persist($user);
            $this->entityManager->flush();

            $io->success('Un nouvel administrateur a été créé !');
            return Command::SUCCESS;
        }
    }
}
