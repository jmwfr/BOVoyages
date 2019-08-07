<?php

namespace App\Controller;

use App\Entity\Voyageur;
use App\Form\VoyageurType;
use App\Repository\VoyageurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/voyageur")
 */
class VoyageurController extends AbstractController
{
    /**
     * @Route("/", name="voyageur_index", methods={"GET"})
     */
    public function index(VoyageurRepository $voyageurRepository): Response
    {
        return $this->render('voyageur/index.html.twig', [
            'voyageurs' => $voyageurRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="voyageur_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $voyageur = new Voyageur();
        $form = $this->createForm(VoyageurType::class, $voyageur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($voyageur);
            $entityManager->flush();

            return $this->redirectToRoute('voyageur_index');
        }

        return $this->render('voyageur/new.html.twig', [
            'voyageur' => $voyageur,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="voyageur_show", methods={"GET"})
     */
    public function show(Voyageur $voyageur): Response
    {
        return $this->render('voyageur/show.html.twig', [
            'voyageur' => $voyageur,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="voyageur_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Voyageur $voyageur): Response
    {
        $form = $this->createForm(VoyageurType::class, $voyageur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('voyageur_index');
        }

        return $this->render('voyageur/edit.html.twig', [
            'voyageur' => $voyageur,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="voyageur_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Voyageur $voyageur): Response
    {
        if ($this->isCsrfTokenValid('delete'.$voyageur->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($voyageur);
            $entityManager->flush();
        }

        return $this->redirectToRoute('voyageur_index');
    }
}
