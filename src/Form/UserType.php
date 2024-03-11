<?php

declare(strict_types=1);

namespace App\Form;

use App\Entity\Dictionary\PositionDictionary;
use App\Entity\User;
use App\Form\Listener\UserLinkListener;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function __construct(private readonly UserLinkListener $linkListener)
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', TextType::class)
            ->add('password', PasswordType::class, [
                'mapped' => false,
                'required' => false,
            ])
            ->add('name', TextType::class)
            ->add('surname', TextType::class)
            ->add('links', CollectionType::class, [
                'entry_type' => UserLinkType::class,
                'by_reference' => false,
                'allow_add' => true,
                'allow_delete' => true,
                'entry_options' => [
                    'label' => false,
                ],
                'label' => false,
            ])
        ;

        if ($options['isAdmin']) {
            $builder->add('positions', EntityType::class, [
                'class' => PositionDictionary::class,
                'multiple' => true,
                'choice_label' => 'name',
            ]);
        }

        $builder->addEventListener(FormEvents::PRE_SET_DATA, [$this->linkListener, 'onPreSetData']);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'isAdmin' => false,
        ]);
    }
}
