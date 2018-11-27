<?php


namespace App\Controller;


use App\Entity\County;
use App\Entity\Item;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/county")
 */
class CountyController extends BaseController
{
    /**
     * @Route("/{id}", name="county_show", methods="GET")
     */
    public function show(County $county): Response
    {
        $items = $this->getDoctrine()->getRepository(Item::class)->findBy(["county" => $county]);
        return $this->render('county/show.html.twig', ['county' => $county, "items" => $items]);
    }

    public function listing()
    {
        $counties = $this->getDoctrine()->getRepository(County::class)->findAll();
        return $this->render(
            'county/listing.html.twig',
            array('counties' => $counties)
        );
    }
}