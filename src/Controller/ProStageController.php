<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Stage;
use App\Entity\Entreprise;
use App\Entity\Formation;
use App\Repository\StageRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use App\Form\EntrepriseType;
use App\Form\StageType;
use App\Form\EntityType;

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
     * @Route("/stages/ajouter", name="pro_stage_ajout_stage")
     */
    public function ajouterStage(StageRepository $repositoryStage, ObjectManager $manager, Request $request)
    {
        // Création d'un stage vierge
        $stage=new Stage();

        // Création de l'objet formulaire à partir du formulaire externalisé
        $formulaireStage=$this->createForm(StageType::class,$stage);
        
        $formulaireStage->handleRequest($request);

        if ($formulaireStage->isSubmitted() && $formulaireStage->isValid())
        {        
           // Enregistrer la ressource en base de données
           $manager->persist($stage);
           $manager->flush();

           // Rediriger l'utilisateur vers la page d'accueil
           return $this->redirectToRoute('pro_stage');
        }
        
       
        return $this->render('pro_stage/ajoutModifStage.html.twig', ['vueFormulaireStage' => $formulaireStage->createView(), 'action'=>"ajouter"
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
    public function ajouterEntreprise(Request $request, ObjectManager $manager)
    {
        // Création d'une entrprise vierge
        $entreprise=new Entreprise();

        // Création de l'objet formulaire à partir du formulaire externalisé
        $formulaireEntreprise=$this->createForm(EntrepriseType::class,$entreprise);
        
        $formulaireEntreprise->handleRequest($request);

        if ($formulaireEntreprise->isSubmitted() && $formulaireEntreprise->isValid())
        {        
           // Enregistrer la ressource en base de données
           $manager->persist($entreprise);
           $manager->flush();

           // Rediriger l'utilisateur vers la page d'accueil
           return $this->redirectToRoute('pro_stage_entreprise');
        }
        
       
        return $this->render('pro_stage/ajoutModifEntreprise.html.twig', ['vueFormulaireEntreprise' => $formulaireEntreprise->createView(), 'action'=>"ajouter"
        ]);
    }



    /**
     * @Route("/entreprises/modifier/{id}", name="pro_stage_modifEntreprise")
     */
    public function modifierEntreprise(Request $request, ObjectManager $manager, Entreprise $entreprise)
    {
        // Création du formulaire permettant de modifier une ressource
        $formulaireEntreprise = $this->createForm(EntrepriseType::class,$entreprise);

        /* On demande au formulaire d'analyser la dernière requête Http. Si le tableau POST contenu
        dans cette requête contient des variables titre, descriptif, etc. alors la méthode handleRequest()
        récupère les valeurs de ces variables et les affecte à l'objet $entreprise */
        $formulaireEntreprise->handleRequest($request);

         if ($formulaireEntreprise->isSubmitted() && $formulaireEntreprise->isValid())
         {
            // Enregistrer la ressource en base de donnéelse
            $manager->persist($entreprise);
            $manager->flush();

            // Rediriger l'utilisateur vers la page d'accueil
            return $this->redirectToRoute('pro_stage_entreprise');
         }

        // Afficher la page présentant le formulaire d'ajout d'une ressource
        return $this->render('pro_stage/ajoutModifEntreprise.html.twig',['vueFormulaireEntreprise' => $formulaireEntreprise->createView(), 'action'=>"modifier"]);
    }


     /**
     * @Route("menu/formations/", name="pro_stage_formations")
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
     * @Route("menu/formations/{nomFormation}", name="pro_stage_formation_id")
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
