<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Entreprise;
use App\Entity\Formation;
use App\Entity\Stage;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // Création d'un générateur de données faker
        $faker = \Faker\Factory::create('fr_FR'); 

        // Création d'entreprises
        
        $nbEntreprises=30;
        
        for($i=1; $i<= $nbEntreprises; $i++)
        {
            $nomEntr=$faker->company;
            $entreprise = new Entreprise();
            $entreprise->setNom($nomEntr);
            $entreprise->setActivité($faker->realText($maxNbChars = 20, $indexSize = 2));
            $entreprise->setAdresse($faker->streetAddress);
            $entreprise->setSiteWeb("www.$nomEntr.com");

            $tableauEntreprises[$i]=$entreprise;
          
        }

        foreach($tableauEntreprises as $entreprise)
        {
         $manager->persist($entreprise);
        }
        
        // Création des formations
        
        $DUTInfo = new Formation();
        $DUTInfo->setNomLong("Diplôme Universitaire Technologique Informatique");
        $DUTInfo->setNomCourt("DUT Info");

        $LicenceP = new Formation();
        $LicenceP->setNomLong("Licence Professionnelle Multimédia");
        $LicenceP->setNomCourt("LP Multimédia");

        $DUTic = new Formation();
        $DUTic->setNomLong("Diplôme Universitaire en Technologie de l'Information et de la Communication");
        $DUTic->setNomCourt("DU TIC");

        // On regroupe les objets "Formation" dans un tableau
       
        $tableauFormations = array($DUTInfo,$LicenceP,$DUTic);

         // Pour chaque formation
         foreach ($tableauFormations as $formation) {
            // Création des stages associés
            $nbStagesProposesFormation= $faker->numberBetween($min = 0, $max = 10);
            for($i=0; $i <= $nbStagesProposesFormation; $i++)
            {
                $stage=new Stage();
                $stage->setTitre($faker->realText($maxNbChars = 20, $indexSize = 2));
                $stage->setDescription($faker->realText($maxNbChars = 20, $indexSize = 2));
                $stage->setEmailContact($faker->companyEmail);
                $stage->addFormation($formation);

              
                // Sélectionner une Entreprise au hasard 
                $numEntreprise = $faker->numberBetween($min = 0, $max = 30);
                // Création relation Stage --> Entreprise
                $stage->setEntreprise($tableauEntreprises[$numEntreprise]);
                // Création relation Entreprise --> Stage
                $tableauEntreprises[$numEntreprise] -> addStage($stage);
                // Persister les objets modifiés
                $manager->persist($stage);
                $manager->persist($tableauEntreprises[$numEntreprise]);
            }

            $manager->persist($formation);
        }


    
        $manager->flush();
    }
}