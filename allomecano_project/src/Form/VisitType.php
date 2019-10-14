<?php

namespace App\Form;

use App\Entity\Visit;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class VisitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            // ->add('date', DateType::class, [
            //     'widget' => 'single_text'
            // ])
            // ->add('time', TimeType::class, [
            //     'widget' => 'single_text'
            // ])
             ->add('reservationDate')
            // ->add('createdAt')
            // ->add('updatedAt')
             ->add('user')
            // ->add('garage')
             ->add('service');
            //  ->addEventListener(
            //     FormEvents::PRE_SET_DATA,
            //     function (FormEvent $event) {
            //         /** @var Article|null $data */
            //         $data = $event->getData();
            //         if (!$data) {
            //             return;
            //         }
            //         $this->setupSpecificLocationNameField(
            //             $event->getForm(),
            //             $data->getLocation()
            //         );
            //     }
            // );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Visit::class,
        ]);
    }
}
