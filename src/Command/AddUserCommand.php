<?php

namespace App\Command;

use App\Entity\User;
use App\Enum\RoleEnum;
use App\Repository\UserRepository;
use App\Service\Factory\UserFactory;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\HelperInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsCommand(
    name: 'create:user',
    description: 'Command for managing users',
    aliases: ['cr:us'],
)]
class AddUserCommand extends Command
{
    public function __construct(
        private readonly ManagerRegistry $doctrine,
        private readonly UserPasswordHasherInterface $passwordHasher,
        private readonly UserRepository $userRepository
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $helper = $this->getHelper('question');

        $email = $this->askEmail("Please enter your email: ");
        $email = $helper->ask($input, $output, $email);

        $user = $this->userRepository->findOneBy(['email' => $email]);

        if($user) {
            return $this->updateUser($helper, $input, $output, $user);
        }

        return $this->createUser($helper, $input, $output, $email);
    }
    public function updateUser(HelperInterface $helper, InputInterface $input, OutputInterface $output, User $user): int
    {
        $isChanged = false;
        $io = new SymfonyStyle($input, $output);

        if (!$io->confirm("Account with this email already exists\n Do you want to update credentials?\n", false)) {
            return Command::SUCCESS;
        }

        $email = $this->askEmail("Please update your email: ", true);
        $email = $helper->ask($input, $output, $email);

        if ($email){
            $this->askConfirmation($email, $helper, $input, $output, $io, $this->askEmail("Confirm Email: "));
            $user->setEmail($email);
            $isChanged = true;
        }

        $password = $this->askPassword("Enter your new password:", true);
        $password = $helper->ask($input, $output, $password);

        if($password){
            $this->askConfirmation($password, $helper, $input, $output, $io, $this->askPassword("Confirm Password:"));
            $isChanged = true;
            $user->setPassword($password);
        }

        $role = $this->askRole("Please choose your new role:", true);
        $role = $helper->ask($input, $output, $role);

        if ($role !== "exit" && $role !== $user->getRoles()) {
            $user->setRoles([$role]);
            $isChanged = true;
        }

        $this->save($user);
        if($isChanged)
        {
            $io->success("You successfully edited credentials");
        } else {
            $io->success("You successfully ran the command without editing editing credentials");
        }
        return Command::SUCCESS;
    }
    public function createUser(HelperInterface $helper, InputInterface $input, OutputInterface $output, string $email): int
    {
        $io = new SymfonyStyle($input, $output);

        $password = $this->askPassword("Enter your password:");
        $password = $helper->ask($input, $output, $password);
        $this->askConfirmation($password, $helper, $input, $output, $io, $this->askPassword("Confirm Password:"));

        $role = $this->askRole("Please choose your role:");
        $role = $helper->ask($input, $output, $role);

        $user = UserFactory::createUser(
            $this->passwordHasher,
            $email,
            password_hash($password, PASSWORD_DEFAULT),
            [$role]
        );

        $this->save($user);
        $io->success("You successfully registered user with credentials:\nemail: $email\npassword: $password\nrole: $role");
        return Command::SUCCESS;
    }
    public function askEmail(string $question, bool $nullable = false): Question
    {
        $emailQuestion = new Question($question."\n > ");
        $emailQuestion->setValidator(function (?string $email) use ($nullable): ?string {
            if (!$email && $nullable) {
                return $email;
            }
            if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                throw new \RuntimeException(
                    'Please enter valid email address'
                );
            }

            return $email;
        });
        $emailQuestion->setMaxAttempts(3);

        return $emailQuestion;
    }
    public function askPassword(string $question, bool $nullable = false): Question
    {
        $passwordQuestion = new Question($question."\n > ");
        $passwordQuestion->setHidden(true);
        $passwordQuestion->setHiddenFallback(false);
        $passwordQuestion->setValidator(function (?string $password) use ($nullable): ?string {
            $error = null;
            if (!$password && $nullable) {
                return $password;
            }
            if (!$password) {
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

        return $passwordQuestion;
    }
    public function askRole(string $question, bool $nullable = false): Question
    {
        $choices = RoleEnum::getChoices();
        if ($nullable) {
            array_unshift($choices, "exit");
        }
        return new ChoiceQuestion($question."\n > ", $choices, 0);
    }
    public function askConfirmation(
        string $parameter,
        HelperInterface $helper,
        InputInterface $input,
        OutputInterface $output,
        SymfonyStyle $io,
        Question $question,
    ): void {
        $parameterConfirmation = false;
        while ($parameter !== $parameterConfirmation) {
            $parameterConfirmation = $helper->ask($input, $output, $question);

            if ($parameterConfirmation !== $parameter) {
                $io->warning("Inputs do not match");
            }
        }
    }
    public function save(User $user): void
    {
        $entityManager = $this->doctrine->getManager();
        $user->setPassword(password_hash($user->getPassword(), PASSWORD_DEFAULT));
        $entityManager->persist($user);
        $entityManager->flush();
    }
}
