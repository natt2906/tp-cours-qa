<?php

namespace App\Controller;

use App\Entity\Prefecture;
use App\Form\PrefectureType;
use App\Repository\PrefectureRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/prefecture")
 */
class PrefectureController extends AbstractController
{
    /**
     * @Route("/", name="prefecture_index", methods={"GET"})
     */
    public function index(PrefectureRepository $prefectureRepository): Response
    {
        return $this->render('prefecture/index.html.twig', [
            'prefectures' => $prefectureRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="prefecture_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $prefecture = new Prefecture();
        $form = $this->createForm(PrefectureType::class, $prefecture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($prefecture);
            $entityManager->flush();

            return $this->redirectToRoute('prefecture_index');
        }

        return $this->render('prefecture/new.html.twig', [
            'prefecture' => $prefecture,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="prefecture_show", methods={"GET"})
     */
    public function show(Prefecture $prefecture): Response
    {
        return $this->render('prefecture/show.html.twig', [
            'prefecture' => $prefecture,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="prefecture_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Prefecture $prefecture): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $form = $this->createForm(PrefectureType::class, $prefecture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('prefecture_index');
        }

        return $this->render('prefecture/edit.html.twig', [
            'prefecture' => $prefecture,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="prefecture_delete", methods={"POST"})
     */
    public function delete(Request $request, Prefecture $prefecture): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        if ($this->isCsrfTokenValid('delete'.$prefecture->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($prefecture);
            $entityManager->flush();
        }

        return $this->redirectToRoute('prefecture_index');
    }
}
