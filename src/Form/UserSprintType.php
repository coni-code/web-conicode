<?php

namespace App\Form;

use App\Entity\SprintUser;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserSprintType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('availabilityInHours', NumberType::class, [
                'label' => 'Your Availability (hours)',
                'required' => false,
                'attr' => ['min' => 0]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SprintUser::class,
        ]);
    }
}
