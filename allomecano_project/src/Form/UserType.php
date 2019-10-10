<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('firstname', TextType::class, [
            'label' => 'Prénom'
            ])
        ->add('lastname', TextType::class, [
            'label' => 'Nom'
            ])
        ->add('email', EmailType::class, [
            'constraints' => [
                new NotBlank(),
                new Assert\Email()
                ]
            ])
        ->add('phone', TelType::class, [
            'label' => 'Téléphone',
            'required' => true,
            'constraints' => [
                new NotBlank(),
                new Assert\Length([
                'min' => 10,
                'max' => 10,])]
            ])
        ->add('adress', TextType::class, [
            'label' => 'Adresse'
            ])
        ->add('gps', TextType::class, [
            'label' => false,
            'required' => false,
            'attr' => array('style' => 'visibility : hidden; width : 0%')
            ])
        // ->add('city', TextType::class, [
        //     'label' => 'Ville'
        //     ])
        // ->add('postalCode', NumberType::class, [
        //     'label' => 'Code Postal',
        //     'constraints' => [
        //         new NotBlank(),
        //         new Assert\Length([
        //         'min' => 5,
        //         'max' => 5,])]
        //     ])
        ->add('avatar', FileType::class, [
            'label' => 'Avatar',
            'data_class' => null,
            'required' => false,
            'required' => false,
            ])
        ->add('username', TextType::class, [
            'label' => 'Pseudo',
            'constraints' => [
                new NotBlank(),
                new Assert\Length([
                'min' => 2,
                'max' => 50,
                'minMessage' => 'Votre nom d\'utilisateur doit être au minimum de {{ limit }} caractères',
            'maxMessage' => 'Votre nom d\'utilisateur doit être au maximum de {{ limit }} caractères'])]
            ])
        ->add('roles', CollectionType::class, [
            'entry_type'   => ChoiceType::class,
            'entry_options'  => [
                'multiple' => false,
                'label' => false,
                'choices' => [
                    'User' => 'ROLE_USER',
                    'Admin' => 'ROLE_ADMIN',
                    'Moderateur' => 'ROLE_MODERATEUR',
            ]]])
        ->add('password', RepeatedType::class, [
            'type' => PasswordType::class,
            'invalid_message' => 'Les mots de passe des deux champs doivent être identiques',
            'options' => ['attr' => ['class' => 'password-field', 'class' => 'input']],
            'required' => true,
            'first_options'  => ['label' => 'Mot de passe'],
            'second_options' => ['label' => 'Confirmation de mot de passe'],])
    ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
