<?php


namespace App\DataFixtures;

use App\Entity\Item;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;


class ItemFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        $objet = new Item();
        $createdat = $faker->dateTimeThisYear('now', 'Europe/Paris');
        $objet->setCreatedAt($createdat);
        $objet->setDateBegin(new \DateTime("2018-11-21"));
        $objet->setName("Portefeuille retrouvé à l'arrêt de bus");
        $objet->setDescription("Lorem ipsum dolor sit amet, consectetur adipisicing elit. Adipisci architecto cum ducimus eaque eligendi et laudantium nostrum porro possimus, provident quam quibusdam recusandae rem similique unde? Laboriosam officiis suscipit vero.");
        $objet->setCity("Rennes");
        $objet->setPhoto("image-1.jpg");
        $objet->setCategory($this->getReference('category-portefeuille'));
        $objet->setStatus($this->getReference('status-trouve'));
        $objet->setUser($this->getReference('user-1'));
        $objet->setCounty($this->getReference('county-ille'));
        $manager->persist($objet);
        $this->addReference('objet-1', $objet);

        $objet_2 = new Item();
        $createdat = $faker->dateTimeThisYear('now', 'Europe/Paris');
        $objet_2->setCreatedAt($createdat);
        $objet_2->setDateBegin(new \DateTime("2018-11-19"));
        $objet_2->setName("Clés rue du général de Gaulle");
        $objet_2->setCity("Brest");
        $objet_2->setPhoto("image-2.jpg");
        $objet->setCategory($this->getReference('category-cles'));
        $objet_2->setStatus($this->getReference('status-trouve'));
        $objet_2->setUser($this->getReference('user-5'));
        $objet_2->setCounty($this->getReference('county-finistere'));
        $manager->persist($objet_2);
        $this->addReference('objet-2', $objet_2);

        $objet_3 = new Item();
        $createdat = $faker->dateTimeThisYear('now', 'Europe/Paris');
        $objet_3->setCreatedAt($createdat);
        $objet_3->setDateBegin(new \DateTime("2018-11-19"));
        $objet_3->setName("Ours en peluche à Sainte-Anne");
        $objet->setDescription("Ours en peluche perdu, urgent");
        $objet_3->setCity("Rennes");
        $objet_3->setPhoto("image-3.jpg");
        $objet->setCategory($this->getReference('category-jouet'));
        $objet_3->setStatus($this->getReference('status-perdu'));
        $objet_3->setUser($this->getReference('user-3'));
        $objet_3->setCounty($this->getReference('county-ille'));
        $manager->persist($objet_3);
        $this->addReference('objet-3', $objet_3);

        $objet_4 = new Item();
        $createdat = $faker->dateTimeThisYear('now', 'Europe/Paris');
        $objet_4->setCreatedAt($createdat);
        $objet_4->setDateBegin(new \DateTime("2018-11-19"));
        $objet_4->setName("Clés perdues à l'IUT");
        $objet_4->setCity("Vannes");
        $objet->setCategory($this->getReference('category-cles'));
        $objet_4->setStatus($this->getReference('status-perdu'));
        $objet_4->setUser($this->getReference('user-3'));
        $objet_4->setCounty($this->getReference('county-morbihan'));
        $manager->persist($objet_4);
        $this->addReference('objet-4', $objet_4);

        $manager->flush();
    }

    public function getDependencies()
    {
        return [CategoryFixtures::class, UserFixtures::class];
    }
}