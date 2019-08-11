<?php

namespace App\Controller;

use App\Repository\VoyageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * @param VoyageRepository $voyageRepository
     * @return Response
     */
    public function index(VoyageRepository $voyageRepository)
    {
        $voyages = $voyageRepository->findLastTwelveNotReserved();
        dump($voyages);
        return $this->render('home/index.html.twig', [
            'voyages' => $voyages
        ]);
    }
}
