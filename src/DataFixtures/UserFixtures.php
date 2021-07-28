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
    {//user un
        $user = new User();
        $user->setNom('wick');
        $user->setPrenom('john');
        $user->setDateInscription(new \DateTime());
        $user->setEmail('wick@wick.us');
        $user->setRoles (['ROLE_ADMIN']);
        $user->setPassword($this->passwordEncoder->encodePassword($user, 'wick'));
        $manager->persist($user);
        $user2 = new User();
        $user2->setNom('john');
        $user2->setPrenom('wick');
        $user2->setDateInscription(new \DateTime("2020-12-24"));
        $user2->setEmail('john@john.us');
        $user2->setPassword($this ->passwordEncoder->encodePassword($user2, 'john'));
        $manager->persist($user2);
        $manager->flush();
    }
}
