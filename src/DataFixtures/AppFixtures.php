<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Entreprise;
use App\Entity\Formation;
use App\Entity\Stage;
use App\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
        {
            $this->passwordEncoder = $passwordEncoder;
        }

    public function load(ObjectManager $manager)
    {

        // Création d'un générateur de données faker
        $faker = \Faker\Factory::create('fr_FR'); 

        // Création de 2 utilisateurs
        $emma= new User();
        $emma->setEmail("auzi.emma@gmail.com");
        $emma->setRoles(["ROLE_ADMIN"]);
        $plainPassword="emma";
        $emma->setPassword($this->passwordEncoder->encodePassword($emma,$plainPassword));
        
        $arthur= new User();
        $arthur->setEmail("arthur.murillo@gmail.com");
        $plainPassword2="arthur";
        $arthur->setRoles(["ROLE_USER"]);
        $arthur->setPassword($this->passwordEncoder->encodePassword($arthur,$plainPassword2));
        
        $manager->persist($emma);
        $manager->persist($arthur);
 

        // Création d'entreprises
        
        $nbEntreprises=30;
        
        for($i=1; $i<= $nbEntreprises; $i++)
        {
            $nomEntr=$faker->company;
            $entreprise = new Entreprise();
            $entreprise->setNom($nomEntr);
            $entreprise->setActivite($faker->realText($maxNbChars = 20, $indexSize = 2));
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
        $DUTInfo->setNomLong("Diplôme Univ Techno Info");
        $DUTInfo->setNomCourt("DUT Info");

        $LicenceP = new Formation();
        $LicenceP->setNomLong("Licence Pro Multimédia");
        $LicenceP->setNomCourt("LP Multimédia");

        $DUTic = new Formation();
        $DUTic->setNomLong("Diplôme de l'Info et de la Com");
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
                $numEntreprise = $faker->numberBetween($min = 1, $max = 30);
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
