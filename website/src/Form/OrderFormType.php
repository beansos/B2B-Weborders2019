<?php

namespace App\Form;

use App\Entity\Orders;
use App\Entity\Products;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrderFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('userId')
            ->add('deliveryDate')
            ->add('Products', EntityType::class, [
                'required' => false,
                'label' => false,
                'class' => Products::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true
            ])
//            ->add('quantity', TextType::class, [
//                'required' => false,
//
//            ])

            ->add('Confirm', SubmitType::class, [
                'label' => 'Confirmer'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Orders::class,
        ]);
    }
}
