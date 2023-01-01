<?php

namespace App\Controller;

use App\Repository\EtablissementRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class FavorisController extends AbstractController
{
    #[Route('/favoris', name: 'app_favoris')]
    public function index(EntityManagerInterface $manager,Security $security,Request $request,UserRepository $userRepository,EtablissementRepository $etablissementRepository): Response
    {
        $userId = $security->getUser()->getId();
        $etablissementId = $request->request->get('id');

        $reponse='erreur';
        $etablissement= $etablissementRepository->find($etablissementId);
        $user= $userRepository->find($userId);
        $nbFavoris= $etablissement->getFavoris();
        $nbFavoris= $nbFavoris->count();
            if ($nbFavoris!=0){
                /* si deja en favori on l'enleve
                DELETE FROM etablissement_user
                WHERE `etablissement_user`.`etablissement_id` = 1
                AND `etablissement_user`.`user_id` = 10
                */
                $etablissement->removeFavori($user);
                $reponse ="L'etablissement est suprimer de favoris";
            }
            else{
                $etablissement->addFavori($user);
                $reponse ="L'etablissement est ajouter aux favoris";
            }

        $manager->persist($etablissement);
        $manager->flush();
        return $this->render('favoris/index.html.twig', [
            'response'=>$reponse,
        ]);
    }

}
