<?php



namespace App\Controller;

use App\Repository\EtablissementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EtablissementController extends AbstractController
{
    private $etablissementRepository;

    public function __construct(EtablissementRepository $etablissementRepository)
    {
        $this->etablissementRepository = $etablissementRepository;
    }

    #[Route('/etablissement/{slug}', name: 'app_etablissement')]
    public function details($slug): Response
    {

        $etablissement = $this->etablissementRepository->findOneBy(['slug' => $slug]);

        if (!$etablissement) {
            throw $this->createNotFoundException(sprintf('pas d\'etablissement avec se slug "%s"', $slug));
        }

        return $this->render('etablissement/details.html.twig', [
            'etablissement' => $etablissement,
        ]);
    }
}
