<?php


namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
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
        $admin = new User();
        $admin->setFirstname("Pierre");
        $admin->setLastname("Jehan");
        $admin->setEmail("pierre.jehan@gmail.com");
        $admin->setPassword($this->passwordEncoder->encodePassword($admin, "pjehan"));
        $admin->setRoles(["ROLE_ADMIN"]);
        $manager->persist($admin);

        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < 20; $i++) {
            $user = new User();
            $user->setFirstname($faker->firstName);
            $user->setLastname($faker->lastName);
            $user->setEmail($faker->email);
            $user->setPassword($this->passwordEncoder->encodePassword($user, "1234"));
            $user->setPhoto("user-" . $i);
            $user->setRoles(["ROLE_USER"]);
            $manager->persist($user);
            $this->addReference('user-' . ($i + 1), $user);
        }

        $manager->flush();
    }
}