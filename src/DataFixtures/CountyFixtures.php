<?php

namespace App\DataFixtures;

use App\Entity\County;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class CountyFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $ille = new County();
        $ille->setName("Ille-et-Vilaine");
        $ille->setZipcode(35);
        $manager->persist($ille);
        $this->addReference('county-ille', $ille);

        $cotes = new County();
        $cotes->setName("Côtes d'Armor");
        $cotes->setZipcode(22);
        $manager->persist($cotes);
        $this->addReference('county-cotes', $cotes);

        $finistere = new County();
        $finistere->setName("Finistère");
        $finistere->setZipcode(29);
        $manager->persist($finistere);
        $this->addReference('county-finistere', $finistere);

        $morbihan = new County();
        $morbihan->setName("Morbihan");
        $morbihan->setZipcode(56);
        $manager->persist($morbihan);
        $this->addReference('county-morbihan', $morbihan);

        $manager->flush();
    }
}
