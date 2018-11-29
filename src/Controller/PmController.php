<?php

namespace App\Controller;

use App\Entity\Pm;
use App\Form\PmType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/pm")
 */
class PmController extends AbstractController
{
    /**
     * @Route("/", name="pm_index", methods="GET")
     */
    public function index(): Response
    {
        $pms = $this->getDoctrine()
            ->getRepository(Pm::class)
            ->findAll();

        return $this->render('pm/index.html.twig', ['pms' => $pms]);
    }

    /**
     * @Route("/new", name="pm_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $pm = new Pm();
        $form = $this->createForm(PmType::class, $pm);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($pm);
            $em->flush();

            return $this->redirectToRoute('pm_index');
        }

        return $this->render('pm/new.html.twig', [
            'pm' => $pm,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="pm_show", methods="GET")
     */
    public function show(Pm $pm): Response
    {
        return $this->render('pm/show.html.twig', ['pm' => $pm]);
    }

    /**
     * @Route("/{id}/edit", name="pm_edit", methods="GET|POST")
     */
    public function edit(Request $request, Pm $pm): Response
    {
        $form = $this->createForm(PmType::class, $pm);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('pm_index', ['id' => $pm->getId()]);
        }

        return $this->render('pm/edit.html.twig', [
            'pm' => $pm,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="pm_delete", methods="DELETE")
     */
    public function delete(Request $request, Pm $pm): Response
    {
        if ($this->isCsrfTokenValid('delete'.$pm->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($pm);
            $em->flush();
        }

        return $this->redirectToRoute('pm_index');
    }
}
