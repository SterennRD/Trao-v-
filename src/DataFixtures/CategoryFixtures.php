<?php


namespace App\DataFixtures;


use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Category;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        $portefeuille = new Category();
        $portefeuille->setLabel("Portefeuille");
        $portefeuille->setColor("#dc143c");
        $portefeuille->setIcon("fa-money");
        $manager->persist($portefeuille);
        $this->addReference("category-portefeuille", $portefeuille);

        $cles = new Category();
        $cles->setLabel("Clés");
        $cles->setColor("#1480dc");
        $cles->setIcon("fa-key");
        $manager->persist($cles);
        $this->addReference("category-cles", $cles);

        $jouet = new Category();
        $jouet->setLabel("Jouet");
        $jouet->setColor("#dccd14");
        $jouet->setIcon("fa-key");
        $manager->persist($jouet);
        $this->addReference("category-jouet", $jouet);

        $manager->flush();
    }
}