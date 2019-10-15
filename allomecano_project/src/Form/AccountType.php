<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class AccountType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
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
            ->add('firstname', TextType::class, [
                'label' => 'Prénom'
                ])
            ->add('lastname', TextType::class, [
                'label' => 'Nom'
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
            ->add('avatar', FileType::class, [
                'label' => 'Avatar',
                'data_class' => null,
                'required' => false,
                'required' => false,
                ])
            ->add('email')
            ->add('gps', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => array('style' => 'visibility : hidden; width : 0%')
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
