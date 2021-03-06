<?php

namespace App\Form;

use App\Entity\Garage;
use App\Entity\Service;
use App\Form\GarageImagesType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class GarageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom de votre garage'
            ])
            ->add('presentation', TextareaType::class, [
                'label' => 'Texte de présentation',
                'required' => false,
                'attr' => [
                    'style' => 'min-height: 100px'
                ]
            ])
            ->add('adress', TextType::class, [
                'label' => 'Adresse de votre garage'
            ])
            // ->add('city')
            // ->add('postalCode')
            // ->add('createdAt')
            // ->add('updatedAt')
            ->add('mobility', CheckboxType::class, [
                'required' => false
            ])
            ->add('avatar', FileType::class, [
                'label' => 'Avatar',
                'data_class' => null,
                'required' => false,
                'required' => false,
                ])
            ->add('distance', IntegerType::class, [
                'label' => 'Distance en kms',
                'required' => false
            ])
            ->add('gps', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => array('style' => 'visibility : hidden; width : 0%')
            ])
            ->add('service', EntityType::class, [
                // looks for choices from this entity
                'class' => Service::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true,
            ])
            ->add('images', FileType::class, [
                'multiple' => true,
                'mapped' => false,
                'required' => false
            ]);
                // uses the User.username property as the visible option string;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Garage::class,
        ]);
    }
}