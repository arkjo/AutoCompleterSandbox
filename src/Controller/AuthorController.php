<?php

namespace App\Controller;

use App\Entity\Author;
use App\Form\AuthorType;
use App\Repository\AuthorRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class AuthorController extends AbstractController
{
    /**
     * @Route("/search-author", name="search_author", defaults={"_format"="json"})
     * @Method("GET")
     */
    public function searchAction(AuthorRepository $repo, Request $request): Response
    {
        $qs = $request->query->get('q', $request->query->get('term', ''));
        $authors = $repo->findLike($qs);

        return $this->render('author/search.json.twig', ['authors' => $authors]);
    }

    /**
     * @Route("/get-author/{id}", name="get_author", defaults={"_format"="json"})
     * @Method("GET")
     */
    public function getAction(int $id = null, AuthorRepository $repo): Response
    {
        if (null === $author = $repo->find($id)) {
            throw $this->createNotFoundException();
        }

        return $this->json($author->getName());
    }

    /**
     * You can use this action to add new author, both in "classic" mode and in an ajax modal.
     *
     * @Route("/new-author", name="new_author")
     * @Method({"GET", "PUT"})
     */
    public function newAction(AuthorRepository $repo, Request $request): Response
    {
        $author = new Author();
        $form = $this->createForm(AuthorType::class, $author, [
            'method' => 'PUT',
            // notice that we need to explicit 'action', otherwise modal form will not work
            'action' => $this->generateUrl('new_author'),
        ]);
        if ($form->handleRequest($request)->isSubmitted() && $form->isValid()) {
            $repo->add($author);
            if ($request->isXmlHttpRequest()) {
                return $this->json(['id' => $author->getId(), 'name' => $author->getName(), 'type' => 'author']);
            }
            $this->addFlash('success', 'New author added.');

            return $this->redirectToRoute('homepage');
        }

        return $this->render('author/new.html.twig', ['form' => $form->createView()]);
    }
}
