<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Stage;
use App\Entity\Entreprise;
use App\Entity\Formation;

class ProStageController extends AbstractController
{
    /**
     * @Route("/", name="pro_stage")
     */
    public function index()
    {

        $repositoryStage=$this->getDoctrine()->getRepository(Stage::class);

        $stages=$repositoryStage->findAll();


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
        return $this->render('pro_stage/stages.html.twig', [
            'controller_name' => 'ProStageController',
            'valeur_id' => $id,
        ]);
    }

    /**
     * @Route("/entreprises/{id}", name="pro_stage_entreprise_id")
     */

    public function listeStagesParEntreprise($id)
    {
        $repositoryEntreprise=$this->getDoctrine()->getRepository(Entreprise::class);
        $entreprise=$repositoryEntreprise->find($id);

        $repositoryStage=$this->getDoctrine()->getRepository(Stage::class);
        $stages=$repositoryStage->findByEntreprise($id);
        
        
        return $this->render('pro_stage/listeStagesParEntreprise.html.twig', [
            'controller_name' => 'ProStageController',
            "entreprise" => $entreprise, "stages" => $stages,
        ]);
    }
   
}
