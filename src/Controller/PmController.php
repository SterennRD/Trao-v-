<?php

namespace App\Controller;

use App\Entity\Item;
use App\Entity\Pm;
use App\Entity\User;
use App\Form\PmType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
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
        $id = $this->getUser()->getId();

        $pms_sent = $this->getDoctrine()
            ->getRepository(Pm::class)
            ->findBy(['userFrom' => $id]);
        $pms_received = $this->getDoctrine()
            ->getRepository(Pm::class)
            ->findBy(['userTo' => $id]);

        return $this->render('pm/index.html.twig', [

            'pms_sent' => $pms_sent,
            'pms_received' => $pms_received,
        ]);
    }

    /**
     * @Route("/new", name="pm_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $pm = new Pm();
        $id = $request->get('id');


        $form = $this->createForm(PmType::class, $pm);
        if ($id) {
            $user_to = $this->getDoctrine()->getRepository(User::class)->findOneBy(['id' => $id]);
            $pm->setUserTo($user_to);
        } else {
            $form = $this->createFormBuilder($pm)
                ->add('title', TextType::class, array('label' => 'Titre'))
                ->add('content', TextareaType::class, array('label' => 'Contenu'))
                ->add('userTo')
                ->getForm()
            ;
        }
        $pm->setDate(new \DateTime());
        $pm->setUserFrom($this->getUser());
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
