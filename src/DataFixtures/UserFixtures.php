<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $tabEmail = array(
            array("email" => "root@local.io", "role" => "ROLE_ADMIN"),
            array("email" => "benoit@local.io", "role" => "ROLE_USER")
        );

        foreach ($tabEmail as $dataUser) {
            $user = new User();
            $user->setEmail($dataUser["email"]);
            $user->setRoles(array($dataUser["role"]));
            $user->setPassword($this->passwordEncoder->encodePassword(
                $user,
                't@st'
            ));
            $manager->persist($user);
        }

        $manager->flush();
    }
}
