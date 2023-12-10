<?php

namespace App\Command;

use App\Enum\RoleEnum;
use App\Service\Factory\UserFactory;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Validation;

#[AsCommand(
    name: 'app:add-user',
    description: 'Command for managing users',
)]
class AddUserCommand extends Command
{
    public function __construct(
        private readonly ManagerRegistry $doctrine
    )
    {
        parent::__construct();
    }

    protected function configure(): void
    {
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $helper = $this->getHelper('question');

        $emailQuestion = new Question("Please enter your email:\n > ");
        $emailQuestion->setValidator(function (?string $email): string {
            if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                throw new \RuntimeException(
                    'Please enter valid email address'
                );
            }
            return $email;
        });
        $emailQuestion->setMaxAttempts(3);
        $email = $helper->ask($input, $output, $emailQuestion);

        $passwordQuestion = new Question("Please enter your password:\n > ");
        $passwordQuestion->setHidden(true);
        $passwordQuestion->setHiddenFallback(false);
        $passwordQuestion->setValidator(function (?string $password): string {
            $error = null;
            if (is_null($password)) {
                $error = 'Password cannot be empty.';
            } elseif (strlen($password) < 6) {
                $error = 'Password should be at least 6 characters long.';
            } elseif (!preg_match('/^(?=.*\d)(?=.*[A-Z])(?=.*[a-z])(?=.*[-_!@#$%^&*()+]).*$/', $password)) {
                $error = 'Password must contain at least one digit, one uppercase letter, one lowercase letter, and one special character.';
            }

            if ($error) {
                throw new \RuntimeException($error);
            }


            return $password;
        });
        $passwordQuestion->setMaxAttempts(4);
        $password = $helper->ask($input, $output, $passwordQuestion);

        $roleQuestion = new ChoiceQuestion("Please choose your role:\n > ", RoleEnum::getChoices(), 0);
        $role = $helper->ask($input, $output, $roleQuestion);

        $user = UserFactory::createUser(
            $email,
            password_hash($password, PASSWORD_DEFAULT),
            [$role]
        );

        $entityManager = $this->doctrine->getManager();

        $entityManager->persist($user);
        $entityManager->flush();

        $io->success("You successfully registered user with credentials:\nemail: $email\npassword: $password\nrole: $role");

        return Command::SUCCESS;
    }
}
