<?php

namespace App\Form;

use App\Entity\OrderItems;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrderItemType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder


//            ->add('orderId')
            ->add('productId')
//            ->add('quantity')


//            ->add('productId',TextType::class, [
//                ])


            ->add('quantity', TextType::class, [
                    'required' => false,
                ])

            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => OrderItems::class,
            'translation_domain' => 'forms'
        ]);
    }


}