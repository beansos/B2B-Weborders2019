<?php

namespace App\DataFixtures;

use App\Entity\Orders;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class OrderFixtures extends Fixture implements DependentFixtureInterface
{

    public const ORDER_REFERENCE = 'order-reference';

    public function load(ObjectManager $manager)
    {
        $user = $this->getReference(UserFixtures::USER_REFERENCE);

        $order = new Orders();
        $order->setTotalExcludingTax(0);
        $order->setTotalTax(0);
        //total weight
        $order->setCreationDate(new \DateTime("2019-12-12 10:0:0"));
        //frequency
        $order->setDeliveryDate(new \DateTime("2019-12-12 18:0:0"));
        $order->setStatus(1);
        $order->setUserId($user);
        $manager->persist($order);
        $manager->flush();


        $this->addReference(self::ORDER_REFERENCE, $order);
    }

    public function getDependencies()
    {
        return array(
            UserFixtures::class,
        );
    }

}
