<?php

namespace App\Controller;

use App\Repository\EtablissementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ListeEtablissementController extends AbstractController
{
    private $etablissementRepository;

    public function __construct(EtablissementRepository $etablissementRepository)
    {
        $this->etablissementRepository = $etablissementRepository;
    }


    #[Route('/etablissements', name: 'app_etablissement')]
    public function index(): Response
    {
        $etablissements = $this->etablissementRepository->findAll();

        return $this->render('etablissement/listeEtablissement.html.twig', [
            'etablissements' => $etablissements,
        ]);
    }

}
