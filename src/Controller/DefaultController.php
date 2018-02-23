<?php

namespace App\Controller;

use App\Repository\BookRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     * @Method("GET")
     */
    public function indexAction(BookRepository $repo)
    {
        $books = $repo->findAll();

        return $this->render('default/index.html.twig', ['books' => $books]);
    }
}
