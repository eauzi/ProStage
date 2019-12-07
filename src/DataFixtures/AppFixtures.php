<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Entreprise;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
         $entrepriseArobiz = new Entreprise();
         $entrepriseArobiz->setNom("Arobiz");
         $entrepriseArobiz->setActivité("Développement web");
         $entrepriseArobiz->setAdresse("100 Avenue de l'Adour");
         $entrepriseArobiz->setSiteWeb("www.arobiz.com");

        $manager->persist($entrepriseArobiz);

        $manager->flush();
    }
}
