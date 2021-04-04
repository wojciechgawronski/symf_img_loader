<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    public function __construct(private UserPasswordEncoderInterface $passwordEncoder)
    {
    }

    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setEmail('woj@gaw');
        $user->setUsername('woj');
        $user->setRoles(['ROLE_USER']);
        $user->setPassword($this->passwordEncoder->encodePassword($user, 'password1'));

        //zatwierdzenie w managerze
        $manager->persist($user);

        $manager->flush();
    }
}
