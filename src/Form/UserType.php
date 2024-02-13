<?php

declare(strict_types=1);

namespace App\Form;

use App\Entity\User;
use App\Enum\PositionEnum;
use App\Enum\RoleEnum;
use App\Repository\UserRepository;
use phpDocumentor\Reflection\PseudoTypes\List_;
use phpDocumentor\Reflection\Types\Collection;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', TextType::class)
            ->add('password', PasswordType::class, [
                'mapped' => false,
                'required' => false,
//                'constraints' => [
//                    new Length([
//                        'min' => 6,
//                        'minMessage' => 'Password should be at least 6 characters long.',
//                    ]),
//                    new Regex([
//                        'pattern' => '/^(?=.*\d)(?=.*[A-Z])(?=.*[a-z])(?=.*[-_!@#$%^&*()+]).*$/',
//                        'message' => 'Password must contain at least one digit, one uppercase letter, one lowercase letter, and one special character.',
//                    ]),
//                ],
            ])
            ->add('name', TextType::class)
            ->add('surname', TextType::class)
            ->add('githubLink', UrlType::class, ['required' => false,])
            ->add('gitlabLink', UrlType::class, ['required' => false,])
            ->add('linkedinLink', UrlType::class, ['required' => false,])
            ->add('websiteLink', UrlType::class, ['required' => false,])
            ->add('youtubeLink', UrlType::class, ['required' => false,])
        ;

        if ($options['isAdmin']) {
            $builder
                ->add('positions', ChoiceType::class, [
                    'choices' => PositionEnum::getChoices(),
                    'multiple' => true
                ])
            ;
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'isAdmin' => false
        ]);
    }
}
