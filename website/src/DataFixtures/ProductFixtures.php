<?php

namespace App\DataFixtures;

use App\Entity\Products;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class ProductFixtures extends Fixture
{

    public const PRODUCT_REFERENCE = 'products-reference';

    public function load(ObjectManager $manager)
    {
         $product = new Products();
         $product->setName("Morning uppercut");
         $product->setPrice(24.50);
         $product->setWeight(1);
         $product->setTax(20);
         $product->setSku("test test sku");
         $manager->persist($product);
         $manager->flush();

        $this->addReference(self::PRODUCT_REFERENCE, $product);

    }
}
