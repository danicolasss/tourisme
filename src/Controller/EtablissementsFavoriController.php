<?php

namespace App\Controller;



use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class EtablissementsFavoriController extends AbstractController
{

    #[Route('/etablissements/favori', name: 'app_etablissements_favori')]
    public function index(Security $security,UserRepository $userRepository): Response
    {
        $userFavoris = $security->getUser()->getId();
        $userFavoris= $userRepository->find($userFavoris)->getFavoris();
        $userFavoris= $userFavoris->getValues();


        return $this->render('etablissements_favori/index.html.twig', [
            'favoris' => $userFavoris,
        ]);
    }
}
