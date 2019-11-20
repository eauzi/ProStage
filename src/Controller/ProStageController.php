<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ProStageController extends AbstractController
{
    /**
     * @Route("/", name="pro_stage")
     */
    public function index()
    {
        return $this->render('pro_stage/index.html.twig', [
            'controller_name' => 'ProStageController',
        ]);
    }
	
	
	 /**
     * @Route("/entreprises", name="pro_stage_entreprise")
     */
    public function afficheEntreprise()
    {
        return $this->render('pro_stage/Entreprises.html.twig', [
            'controller_name' => 'ProStageController',
        ]);
    }

     /**
     * @Route("/formations", name="pro_stage_formations")
     */
    public function afficheFormation()
    {
        return $this->render('pro_stage/Formations.html.twig', [
            'controller_name' => 'ProStageController',
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
}
