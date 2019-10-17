<?php

namespace App\Form;

use App\Entity\Service;
use App\Repository\ServiceRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ServiceSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', EntityType::class, [
                'class' => Service::class,
                'query_builder' => function ( ServiceRepository $service ){
                    return $service->createQueryBuilder('s')->orderBy('s.name', 'ASC');
                },
                'placeholder' => '(Freinage, Vidange...)',
                'label' => false
            ]);
            // ->add('price')
            // ->add('image')
            // ->add('createdAt')
            // ->add('updatedAt')
            // ->add('garages')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Service::class,
        ]);
    }
}
