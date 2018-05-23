<?php

namespace App\Controller;

use App\Entity\Captain;
use App\Form\CaptainType;
use App\Service\AgeService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/captain")
 */
class CaptainController extends Controller
{
    /**
     * @Route("/", name="captain_index", methods="GET")
     */
    public function index(): Response
    {
        $captains = $this->getDoctrine()
            ->getRepository(Captain::class)
            ->findAll();

        return $this->render('captain/index.html.twig', ['captains' => $captains]);
    }

    /**
     * @Route("/new", name="captain_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $captain = new Captain();
        $form = $this->createForm(CaptainType::class, $captain);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($captain);
            $em->flush();

            return $this->redirectToRoute('captain_index');
        }

        return $this->render('captain/new.html.twig', [
            'captain' => $captain,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="captain_show", methods="GET")
     */
    public function show(Captain $captain, AgeService $ageService): Response
    {
        return $this->render('captain/show.html.twig', [
            'captain' => $captain,
            'age' => $ageService->get($captain->getDob()),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="captain_edit", methods="GET|POST")
     */
    public function edit(Request $request, Captain $captain): Response
    {
        $form = $this->createForm(CaptainType::class, $captain);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('captain_edit', ['id' => $captain->getId()]);
        }

        return $this->render('captain/edit.html.twig', [
            'captain' => $captain,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="captain_delete", methods="DELETE")
     */
    public function delete(Request $request, Captain $captain): Response
    {
        if ($this->isCsrfTokenValid('delete'.$captain->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($captain);
            $em->flush();
        }

        return $this->redirectToRoute('captain_index');
    }

    /**
     * @Route("/name/{name}", name="captain_crunch_name")
     */
    public function showName($name)
    {
        $em = $this->getDoctrine()->getManager();
        //$captain = $em->getRepository("App:Captain")->findOneByName($name);
        $captain = $em->getRepository("App:Captain")->findOneBy(['name'=>$name]);
        dump($captain);
        return new Response();
    }
}
