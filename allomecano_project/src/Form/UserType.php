<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints\NotBlank;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('email', EmailType::class, [
            'constraints' => [
                new NotBlank(),
                new Assert\Email()
                ]
        ])
        ->add('username', TextType::class, [
            'label' => 'Nom d\'utilisateur',
            'constraints' => [
                new NotBlank(),
                new Assert\Length([
                'min' => 2,
                'max' => 50,
                'minMessage' => 'Votre nom d\'utilisateur doit être au minimum de {{ limit }} caractères',
            'maxMessage' => 'Votre nom d\'utilisateur doit être au maximum de {{ limit }} caractères'])]
            ])
        ->add('password', RepeatedType::class, [
            'type' => PasswordType::class,
            'invalid_message' => 'Les mots de passe des deux champs doivent être identiques',
            'options' => ['attr' => ['class' => 'password-field', 'class' => 'input']],
            'required' => true,
            'first_options'  => ['label' => 'Mot de passe'],
            'second_options' => ['label' => 'Retapez le mot de passe'],])
    ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
