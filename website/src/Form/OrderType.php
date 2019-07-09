<?php

namespace App\Form;

use App\Entity\OrderItems;
use App\Entity\Orders;
use App\Entity\Products;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('userId')
            ->add('deliveryDate')
//            ->add('Products', EntityType::class, [
//                'required' => false,
//                'label' => false,
//                'class' => Products::class,
//                'choice_label' => 'name',
//                'multiple' => true,
//                'expanded' => true
//            ])

//            ->add('creationDate')
//            ->add('orderItems', OrderItems::class, [
//                'placeholder' => 'Choose a delivery option',
//            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Orders::class,
        ]);
    }
}
