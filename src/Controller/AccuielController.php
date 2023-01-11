<?php

namespace App\Controller;

use App\Repository\EtablissementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Webmozart\Assert\Assert;

class AccuielController extends AbstractController
{

    public function __construct(private EtablissementRepository $etablissementRepository)
    {

    }

    #[Route('/', name: 'app_accuiel')]
    public function index(): Response
    {
        $Etablissements = $this->etablissementRepository->findBy(array('actif' => 'true'),array('ville'=>'asc'));


        return $this->render('accuiel/index.html.twig', [
            'controller_name' => 'AccuielController',
            'Etablissements' => $Etablissements
        ]);
    }
}
