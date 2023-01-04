<?php

namespace App\Controller;

use App\Repository\EtablissementRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class ListeEtablissementController extends AbstractController
{
    private $etablissementRepository;

    public function __construct(EtablissementRepository $etablissementRepository)
    {
        $this->etablissementRepository = $etablissementRepository;
    }


    #[Route('/etablissements', name: 'app_etablissements')]
    public function index(): Response
    {
        $etablissements = $this->etablissementRepository->findAll();

        return $this->render('etablissement/listeEtablissement.html.twig', [
            'etablissements' => $etablissements,
        ]);
    }





}
