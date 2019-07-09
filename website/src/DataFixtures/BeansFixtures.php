<?php

namespace App\DataFixtures;

use App\Entity\Admins;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class BeansFixtures extends Fixture
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $beans = new Admins();
        $beans->setUsername('admin123');
        $beans->setPassword($this->encoder->encodePassword($beans, 'admin123'));
        $manager->persist($beans);
        $manager->flush();
    }
}