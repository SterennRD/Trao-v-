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
        $items_found = $this->getDoctrine()->getRepository(Item::class)->findByStatus(Status::FOUND, Item::MAX_RESULT);
        $items_lost = $this->getDoctrine()->getRepository(Item::class)->findByStatus(Status::LOST, Item::MAX_RESULT);
        $items_resolved = $this->getDoctrine()->getRepository(Item::class)->findItemsResolved();

        return $this->render('default/homepage.html.twig',[
            "items_found" => $items_found,
            "items_lost" => $items_lost,
            'items_resolved' => $items_resolved,
        ]);
    }
}