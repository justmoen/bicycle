<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @return Response
     */
    #[Route('/', name: 'home_page', methods: ["GET"])]
    public function homePage(): Response
    {
        return $this->render('index.html.twig');
    }
}