<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Entity\Voyageur;
use App\Form\ReservationType;
use App\Repository\ReservationRepository;
use App\Repository\VoyageurRepository;
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
    public function new(Request $request, string $id = null): Response
    {
        $user = $this->getUser();
        $entityManager = $this->getDoctrine()->getManager();
        $reservation = new Reservation();

        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            //dump($_POST["reservation"]);
            if (is_null($reservation->getClient()) && empty($_POST['reservation']["clients"]))
            {
                $form->addError(new FormError("Veuillez sélectionner un client ou en ajouter un !"));
            }
            else
            {
                if (is_null($reservation->getClient())) {
                    $clientId = (int)$_POST['reservation']["clients"];
                    $repo = $entityManager->getRepository("App\Entity\Client");
                    $client = $repo->findOneBy(["id" => $clientId]);
                    $reservation->setClient($client);
                }

                $voyageurs = $reservation->getVoyageurs();

                foreach ($voyageurs as $voyageur) {
                    $voyageur->setReservation($reservation);
                }

                $reservation->getVoyage()->setReservation($reservation);

                $entityManager->persist($reservation);
                $entityManager->flush();

                return $this->redirectToRoute('reservation_index');
            }
        }

        return $this->render('reservation/new.html.twig', [
            'reservation' => $reservation,
            'form' => $form->createView(),
            'voyageId' => $id,
            'clientId' => $reservation->getVoyage() ? $reservation->getVoyage()->getId() : null,
            'user' => $user
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
    public function edit(Request $request, Reservation $reservation): Response
    {
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (is_null($reservation->getClient()) && empty($_POST['reservation']["clients"]))
            {
                $form->addError(new FormError("Veuillez sélectionner un client ou en ajouter un !"));
            }
            else
            {
                $this->getDoctrine()->getManager()->flush();
                $this->addFlash("success","Réservation modifiée avec succès !");
                return $this->redirectToRoute('reservation_index');
            }
        }

        return $this->render('reservation/edit.html.twig', [
            'reservation' => $reservation,
            'form' => $form->createView(),
            'voyageId' => $reservation->getVoyage()->getId(),
            'clientId' => $reservation->getClient()->getId()
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
}
