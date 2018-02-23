<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\BookType;
use App\Repository\BookRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class BookController extends AbstractController
{
    /**
     * @Route("/new-book", name="new_book")
     * @Method({"GET", "PUT"})
     */
    public function newAction(BookRepository $repo, Request $request): Response
    {
        $book = new Book();
        $form = $this->createForm(BookType::class, $book, ['method' => 'PUT']);
        if ($form->handleRequest($request)->isSubmitted() && $form->isValid()) {
            $repo->add($book);
            $this->addFlash('success', 'New book added.');

            return $this->redirectToRoute('homepage');
        }

        return $this->render('book/new.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/edit-book/{id}", name="edit_book")
     * @Method({"GET", "POST"})
     */
    public function editAction(Book $book, BookRepository $repo, Request $request): Response
    {
        $form = $this->createForm(BookType::class, $book);
        if ($form->handleRequest($request)->isSubmitted() && $form->isValid()) {
            $repo->add($book);
            $this->addFlash('success', 'Book updated.');

            return $this->redirectToRoute('homepage');
        }

        return $this->render('book/edit.html.twig', ['book' => $book, 'form' => $form->createView()]);
    }
}
