<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Reservation;
use App\Entity\Voyageur;
use App\Form\ReservationType;
use App\Repository\ReservationRepository;
use App\Repository\VoyageurRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/reservation")
 */
class ReservationController extends AbstractController
{
    /**
     * @Route("/", name="reservation_index", methods={"GET"})
     */
    public function index(ReservationRepository $reservationRepository): Response
    {
        $user = $this->getUser();
        return $this->render('reservation/index.html.twig', [
            'reservations' => $reservationRepository->findAll(),
            'user' => $user
        ]);
    }

    /**
     * @Route("/new", name="reservation_new", methods={"GET","POST"})
     * @Route("/new/{id}", name="reservation_new_id", methods={"GET","POST"})
     */
    public function new(Request $request, EntityManagerInterface $em, string $id = null): Response
    {
        $reservation = new Reservation();

        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);
        $data = null;
        $showClient = true;

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $_POST['reservation'];

            if (is_null($reservation->getClient()) && is_null($data['clients']))
            {
                $form->addError(new FormError("Veuillez sélectionner un client ou en ajouter un !"));
            }
            if(is_null($reservation->getClient()) && (empty($data["clients"]["nomClient"]) || empty($data["clients"]["prenomClient"]) || empty($data["clients"]["emailClient"])))
            {
                $form->addError(new FormError("Tous les champs client son obligatoires à l'exception du téléphone !"));
                $showClient = false;
            }
            if(!empty($data["clients"]["nomClient"]) || !empty($data["clients"]["prenomClient"]) || !empty($data["clients"]["emailClient"]))
            {
                $showClient = false;
            }
            if($reservation->getVoyageurs()->count() == 0) {
                $form->addError(new FormError("Merci d'ajouter au moins un voyageur !"));
            }
            else
            {
                if (isset($data["clients"]) && (!empty($data["clients"]["nomClient"]) || !empty($data["clients"]["prenomClient"]) || !empty($data["clients"]["emailClient"]))) {
                    $newClient = $this->createNewClient($data);
                    $reservation->setClient($newClient);
                }

                $em->persist($reservation);
                $em->flush();

                $this->addFlash("success","Réservation créée avec succès !");
                return $this->redirectToRoute('reservation_index');
            }
        }

        return $this->render('reservation/new.html.twig', [
            'reservation' => $reservation,
            'form' => $form->createView(),
            'clientDisplay' => ($showClient) ? 'display:block' : 'display:none',
            'clientsDisplay' => ($showClient) ? 'display:none' : 'display:block'
        ]);
    }

    /**
     * @Route("/{id}", name="reservation_show", methods={"GET"})
     */
    public function show(Reservation $reservation): Response
    {
        return $this->render('reservation/show.html.twig', [
            'reservation' => $reservation,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="reservation_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, EntityManagerInterface $em, Reservation $reservation): Response
    {
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);
        $data = null;
        $showClient = true;

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $_POST['reservation'];

            if (is_null($reservation->getClient()) && is_null($data['clients']))
            {
                $form->addError(new FormError("Veuillez sélectionner un client ou en ajouter un !"));
            }
            if(is_null($reservation->getClient()) && (empty($data["clients"]["nomClient"]) || empty($data["clients"]["prenomClient"]) || empty($data["clients"]["emailClient"])))
            {
                $form->addError(new FormError("Tous les champs client son obligatoires à l'exception du téléphone !"));
                $showClient = false;
            }
            else
            {
                if (isset($data["clients"])) {
                    $newClient = $this->createNewClient($data);
                    $reservation->setClient($newClient);
                }

                $this->getDoctrine()->getManager()->flush();
                $this->addFlash("success","Réservation modifiée avec succès !");
                return $this->redirectToRoute('reservation_index');
            }
        }

        return $this->render('reservation/edit.html.twig', [
            'reservation' => $reservation,
            'form' => $form->createView(),
            'clientDisplay' => ($showClient) ? 'display:block' : 'display:none',
            'clientsDisplay' => ($showClient) ? 'display:none' : 'display:block'
        ]);
    }

    /**
     * @Route("/{id}", name="reservation_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Reservation $reservation): Response
    {
        if ($this->isCsrfTokenValid('delete' . $reservation->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($reservation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('reservation_index');
    }

    private function createNewClient($data) {
        $newClient = new Client();
        $newClient->setNomClient($data["clients"]['nomClient']);
        $newClient->setPrenomClient($data["clients"]['prenomClient']);
        $newClient->setEmailClient($data["clients"]['emailClient']);
        if(!empty($data["clients"]['telClient'])) {
            $newClient->setTelClient($data["clients"]['telClient']);
        }
        return $newClient;
    }
}
