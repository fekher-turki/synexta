<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('lastName', TextType::class, [
                'label' => 'Nom',
                'label_attr' => ['class' => 'form-label'],
                'attr' => [
                    'placeholder' => 'Nom',
                    'class' => 'form-control',
                    'minlength' => '2',
                    'maxlength' => '30'
                ],
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Length(['min' => 2, 'max' => 30]),
                ],
            ])
            ->add('firstName', TextType::class, [
                'label' => 'Prénom',
                'label_attr' => ['class' => 'form-label'],
                'attr' => [
                    'placeholder' => 'Prénom',
                    'class' => 'form-control',
                    'minlength' => '2',
                    'maxlength' => '30'
                ],
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Length(['min' => 2, 'max' => 30]),
                ],
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email',
                'label_attr' => ['class' => 'form-label'],
                'attr' => [
                    'placeholder' => 'Email',
                    'class' => 'form-control',
                    'minlength' => '2',
                    'maxlength' => '180'
                ],
                'constraints' => [
                    new Assert\Email(),
                    new Assert\NotBlank()
                ],
            ])
            ->add('isAccepted', CheckboxType::class, [
                'label' => 'Accepter nos conditions',
                'label_attr' => ['class' => 'form-check-label'],
                'attr' => [
                    'class' => 'form-check-input'
                ],
                'constraints' => [
                    new Assert\NotBlank()
                ],
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Ajouter',
                'attr' => [
                    'class' => 'btn btn-success'
                ],
            ])
            ->add('cancel', ResetType::class, [
                'label' => 'Annuler',
                'attr' => [
                    'class' => 'btn btn-secondary'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
