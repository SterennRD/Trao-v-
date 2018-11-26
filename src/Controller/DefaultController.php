<?php


namespace App\Controller;


use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends BaseController
{
    /** @Route("/", name="homepage") */
    public function index()
    {
        return $this->render('default/homepage.html.twig');
    }
}