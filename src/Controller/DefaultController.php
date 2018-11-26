<?php


namespace App\Controller;


use App\Entity\Item;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends BaseController
{
    /** @Route("/", name="homepage") */
    public function index()
    {
        $items = $this->getDoctrine()->getRepository(Item::class)->findAll();
        return $this->render('default/homepage.html.twig',[
            "items" => $items
        ]);
    }
}