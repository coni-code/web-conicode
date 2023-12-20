<?php

namespace App\Command;

use App\Entity\User;
use App\Enum\RoleEnum;
use App\Repository\UserRepository;
use App\Service\Factory\UserFactory;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
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
        $io = new SymfonyStyle($input, $output);
        $helper = $this->getHelper('question');

        $email = $this->askEmail("Please enter your email:\n > ");
        $email = $helper->ask($input, $output, $email);

        $user = $this->userRepository->findOneBy(['email' => $email]);

        if($user) {
            $io->info("Account with this email already exists exit command or edit your credentials");

            $dataChangeQuestion = new ChoiceQuestion("Choose which credential do you want to update?\n",["EMAIL", "PASSWORD", "ROLE"]);
            $dataChange = $helper->ask($input, $output, $dataChangeQuestion);

            if ($dataChange == 0){
                $email = $this->askEmail("Please enter your new email:\n > ");
                $email = $helper->ask($input, $output, $email);

                $emailConfirmation = $this->askEmail("Please confirm your new email:\n > ");
                $emailConfirmation = $helper->ask($input, $output, $emailConfirmation);

                if ($emailConfirmation !== $email){
                    $io->warning("Emails are not matching");
                }

                $user->setEmail($email);

            } elseif ($dataChange == 1){

                $password = $this->askPassword("Enter your new password:\n  >");
                $password = $helper->ask($input, $output, $password);

                $user->setPassword($password);

            } elseif ($dataChange == 2){

                $role = $this->askRole("Please choose your new role:\n > ");
                $role = $helper->ask($input, $output, $role);

                $user->setRoles($role);

            }

            $successMessage = "You successfully edited credentials";

        } else {
            $password = $this->askPassword("Enter your password:\n  >");
            $password = $helper->ask($input, $output, $password);

            $role = $this->askRole("Please choose your role:\n > ");
            $role = $helper->ask($input, $output, $role);

            $user = UserFactory::createUser(
                $this->passwordHasher,
                $email,
                password_hash($password, PASSWORD_DEFAULT),
                [$role]
            );

            $successMessage = "You successfully registered user with credentials:\nemail: $email\npassword: $password\nrole: $role";
        }
        $entityManager = $this->doctrine->getManager();

        $entityManager->persist($user);
        $entityManager->flush();

        $io->success($successMessage);

        return Command::SUCCESS;
    }
    public function askPassword(string $question): Question
    {
        $passwordQuestion = new Question($question);
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

        return $passwordQuestion;
    }
    public function askEmail(string $question): Question
    {
        $emailQuestion = new Question($question);
        $emailQuestion->setValidator(function (?string $email): string {

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
    public function askRole(string $question): Question
    {
        return new ChoiceQuestion($question, RoleEnum::getChoices(), 0);
    }
}
