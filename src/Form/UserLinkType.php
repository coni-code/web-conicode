<?php

declare(strict_types=1);

namespace App\Form;

use App\Entity\UserLink;
use App\Form\DataTransformers\LinkTypeTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserLinkType extends AbstractType
{
    public function __construct(private readonly LinkTypeTransformer $linkTypeTransformer)
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('url', TextType::class, [
                'required' => false,
            ])
            ->add('type', HiddenType::class)
        ;

        $builder->get('type')->addModelTransformer($this->linkTypeTransformer);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => UserLink::class,
        ]);
    }
}
