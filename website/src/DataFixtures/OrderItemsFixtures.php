<?php

namespace App\DataFixtures;

use App\Entity\OrderItems;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;


class OrderItemsFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        dump("OrderItemsFixtures");


        $order = $this->getReference(OrderFixtures::ORDER_REFERENCE);
        $product = $this->getReference(ProductFixtures::PRODUCT_REFERENCE);
//        dump($order);
//        dump($products);

        $orderitem = new OrderItems();
        $orderitem->setSku($product->getSku());
        $orderitem->setTax($product->getTax());
        $orderitem->setWeight($product->getWeight());
        $orderitem->setPrice($product->getPrice());
        $orderitem->setQuantity(1);
        $orderitem->setOrderId($order);
        $orderitem->setProductId($product);

        $manager->persist($orderitem);
        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            OrderFixtures::class,
            ProductFixtures::class,
        );
    }

}
