<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Stage;
use App\Entity\Entreprise;
use App\Entity\Formation;
use App\Repository\StageRepository;

class ProStageController extends AbstractController
{
    /**
     * @Route("/", name="pro_stage")
     */
    public function index(StageRepository $repositoryStage)
    {
        $stages=$repositoryStage->findStageEtEntrepriseAssociee();

        return $this->render('pro_stage/index.html.twig', [
            'controller_name' => 'ProStageController', "stages"=> $stages,
        ]);
    }
	
	
	 /**
     * @Route("/entreprises", name="pro_stage_entreprise")
     */
    public function afficheEntreprise()
    {
        
        $repositoryEntreprise=$this->getDoctrine()->getRepository(Entreprise::class);
        $entreprises=$repositoryEntreprise->findAll();

        
       
        return $this->render('pro_stage/Entreprises.html.twig', [
            'controller_name' => 'ProStageController', "entreprises" => $entreprises,
        ]);
    }

    /**
     * @Route("/entreprises/ajouter", name="pro_stage_ajout_entreprise")
     */
    public function ajouterEntreprise()
    {
        // Création d'une entrprise vierge
        $entreprise=new Entreprise();

        // Création de l'objet formulaire
        $formulaireEntreprise=$this->createFormBuilder($entreprise)
        ->add('Nom')
        ->add('Activite')
        ->add('Adresse')
        ->add('SiteWeb')
        ->getForm();

        
       
        return $this->render('pro_stage/ajoutEntreprise.html.twig', ['vueFormulaireEntreprise' => $formulaireEntreprise->createView()
        ]);
    }

     /**
     * @Route("/formations", name="pro_stage_formations")
     */
    public function afficheFormation()
    {
        
        $repositoryFormations=$this->getDoctrine()->getRepository(Formation::class);
        $formations=$repositoryFormations->findAll();

        return $this->render('pro_stage/Formations.html.twig', [
            'controller_name' => 'ProStageController', "formations" => $formations,
        ]);
    }

    /**
     * @Route("/stages/{id}", name="pro_stage_id")
     */
    public function afficherStages($id)
    {
        
        $repositoryStage=$this->getDoctrine()->getRepository(Stage::class);
        $stage=$repositoryStage->findOneById($id);

        return $this->render('pro_stage/stages.html.twig', [
            'controller_name' => 'ProStageController',
            'valeur_id' => $id, "stage" => $stage,
        ]);
    }

    /**
     * @Route("/entreprises/{nomEntreprise}", name="pro_stage_entreprise_id")
     */

    public function listeStagesParEntreprise(StageRepository $repositoryStage, $nomEntreprise)
    {
        $stages=$repositoryStage->findStagePourUneEntreprise($nomEntreprise);
        
        
        return $this->render('pro_stage/listeStagesParEntreprise.html.twig', [
            'controller_name' => 'ProStageController',
             "stages" => $stages,
        ]);
    }

    /**
     * @Route("/formations/{nomFormation}", name="pro_stage_formation_id")
     */

    public function listeStagesParFormation(StageRepository $repositoryStage, $nomFormation)
    {
        $stages=$repositoryStage->findStagePourUneFormation($nomFormation);
        
        
        return $this->render('pro_stage/listeStagesParFormation.html.twig', [
            'controller_name' => 'ProStageController',
            "stages" => $stages,
        ]);
    }
   
}
