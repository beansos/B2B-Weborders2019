<?php

namespace App\DataFixtures;

use App\Entity\Users;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public const USER_REFERENCE = 'user-reference';

    public function load(ObjectManager $manager) {
        $user = new Users();
        $user->setName("Dupont");
        $user->setSurname("Michel");
        $user->setEmail("dupont@mail.fr");
        $user->setEnterprise("The tech on fire");

        $manager->persist($user);
        $manager->flush();


        $this->addReference(self::USER_REFERENCE, $user);
    }
}