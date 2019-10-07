<?php

namespace App\Form;

use App\Entity\Comment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class CommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('content', TextareaType::class, [
                'label' => 'Votre avis sur la prestation'
            ])
            ->add('rate', IntegerType::class, [
                'label' => 'Votre note sur 5 :',
                'attr' => [
                    'min' => 0,
                    'max' => 5,
                    'step' => 1
                ]
            ])
            // ->add('createdAt')
            // ->add('enable')
            // ->add('user')
            // ->add('garage')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Comment::class,
        ]);
    }
}
