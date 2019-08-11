<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Voyage;
use App\Form\VoyageType;
use App\Repository\VoyageRepository;
use Stof\DoctrineExtensionsBundle\Uploadable\UploadableManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/voyage")
 */
class VoyageController extends AbstractController
{
    private $uploadableManager;

    /**
     * VoyageController constructor.
     * @param $uploadableManager
     */
    public function __construct(UploadableManager $uploadableManager)
    {
        $this->uploadableManager = $uploadableManager;
    }

    /**
     * @Route("/showAll", name="voyage_all", methods={"GET"})
     */
    public function index(VoyageRepository $voyageRepository): Response
    {
        return $this->render('voyage/indexAll.html.twig', [
            'voyages' => $voyageRepository->findAllNotReserved(),
        ]);
    }

    /**
     * @Route("/", name="voyage_index", methods={"GET"})
     */
    public function indexLogged(VoyageRepository $voyageRepository): Response
    {
        return $this->render('voyage/index.html.twig', [
            'voyages' => $voyageRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="voyage_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $voyage = new Voyage();
        $required = true;

        $form = $this->createForm(VoyageType::class, $voyage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $voyage = $form->getData();

            if($voyage->getUploadedFile() instanceof UploadedFile) {
                $this->uploadableManager->markEntityToUpload($voyage, $voyage->getUploadedFile()); //move the uploaded file, rename it, update the entity
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($voyage);
            $entityManager->flush();

            $this->addFlash("success", "Voyage ajouté avec succès !");
            return $this->redirectToRoute('voyage_index');
        }

        return $this->render('voyage/new.html.twig', [
            'voyage' => $voyage,
            'form' => $form->createView(),
            'required' => $required
        ]);
    }

    /**
     * @Route("/{id}", name="voyage_show", methods={"GET"})
     */
    public function show(Voyage $voyage): Response
    {
        return $this->render('voyage/show.html.twig', [
            'voyage' => $voyage,
        ]);
    }

    /**
     * @Route("/show/{id}", name="voyage_showClient", methods={"GET"})
     */
    public function showClient(Voyage $voyage): Response
    {
        return $this->render('voyage/showClient.html.twig', [
            'voyage' => $voyage,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="voyage_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Voyage $voyage): Response
    {
        $required = false;

        $form = $this->createForm(VoyageType::class, $voyage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $image = 'img/voyage/'.$voyage->getImage();
            $voyage = $form->getData();

            if($voyage->getUploadedFile() instanceof UploadedFile) {
                unlink($image);
                $this->uploadableManager->markEntityToUpload($voyage, $voyage->getUploadedFile()); //move the uploaded file, rename it, update the entity
            }

            $this->getDoctrine()->getManager()->flush();

            $this->addFlash("success", "Voyage mis à jour avec succès !");
            return $this->redirectToRoute('voyage_index');
        }

        return $this->render('voyage/edit.html.twig', [
            'voyage' => $voyage,
            'form' => $form->createView(),
            'required' => $required
        ]);
    }

    /**
     * @Route("/{id}", name="voyage_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Voyage $voyage): Response
    {
        if ($this->isCsrfTokenValid('delete'.$voyage->getId(), $request->request->get('_token'))) {

            $picture = $this->getParameter('voyagePictureFolder').$voyage->getImage();
            unlink($picture);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($voyage);
            $entityManager->flush();

            $this->addFlash("success", "Voyage supprimé avec succès !");
        }

        return $this->redirectToRoute('voyage_index');
    }
}
