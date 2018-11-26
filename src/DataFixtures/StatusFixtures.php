<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Status;

class StatusFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $trouve = new Status();
        $trouve->setLabel("Trouvé");
        $trouve->setIcon("fa-map-pin");
        $trouve->setColor("#4FB956");
        $manager->persist($trouve);
        $this->addReference("status-trouve", $trouve);

        $perdu = new Status();
        $perdu->setLabel("Perdu");
        $perdu->setIcon("fa-map-pin");
        $perdu->setColor("#3D8A8E");
        $manager->persist($perdu);
        $this->addReference("status-perdu", $perdu);

        $resolu = new Status();
        $resolu->setLabel("Résolu");
        $resolu->setIcon("fa-map-pin");
        $resolu->setColor("#3D8A8E");
        $manager->persist($resolu);
        $this->addReference("status-resolu", $resolu);

        $manager->flush();
    }
}
