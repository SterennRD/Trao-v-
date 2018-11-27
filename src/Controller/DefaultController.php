<?php


namespace App\Controller;


use App\Entity\Item;
use App\Entity\Status;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends BaseController
{
    /** @Route("/", name="homepage") */
    public function index()
    {
        $items_found = $this->getDoctrine()->getRepository(Item::class)->findLastStatus(Status::FOUND, 5);
        $items_lost = $this->getDoctrine()->getRepository(Item::class)->findLastStatus(Status::LOST, 5);
        return $this->render('default/homepage.html.twig',[
            "items_found" => $items_found,
            "items_lost" => $items_lost
        ]);
    }
}