<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Entreprise;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // Création d'un générateur de données faker
        $faker = \Faker\Factory::create('fr_FR'); 
        
        $nbEntreprises=30;
        
        for($i=1; $i<= $nbEntreprises; $i++)
        {
            $nomEntr=$faker->company;
            $entreprise = new Entreprise();
            $entreprise->setNom($nomEntr);
            $entreprise->setActivité($faker->realText($maxNbChars = 20, $indexSize = 2));
            $entreprise->setAdresse($faker->streetAddress);
            $entreprise->setSiteWeb("www.$nomEntr.com");
   
           $manager->persist($entreprise);
        }
        
       

        $manager->flush();
    }
}
