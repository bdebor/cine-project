<?php

namespace CineProject\PublicBundle\Controller;

use CineProject\PublicBundle\Entity\Movie;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class MovieController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $movies = $em->getRepository('CineProjectPublicBundle:Movie')->findByIsActive(true);

        return $this->render('CineProjectPublicBundle:Movie:index.html.twig', array('movies' => $movies));
    }

    public function newAction(Request $request)
    {
        $movie = new Movie();
        $form = $this->createForm('CineProject\PublicBundle\Form\MovieType', $movie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($movie);
            $em->flush($movie);

            //return $this->redirectToRoute('actor_show', array('id' => $actor->getId()));
        }

        return $this->render('CineProjectPublicBundle:Movie:new.html.twig', array(
            'movie' => $movie,
            'form' => $form->createView(),
        ));
    }

    public function showAction(Movie $movie)
    {
        //$deleteForm = $this->createDeleteForm($movie);

        return $this->render('CineProjectPublicBundle:Movie:show.html.twig', array(
            'movie' => $movie,
            //'delete_form' => $deleteForm->createView(),
        ));
    }

    public function editAction(Request $request, Movie $movie)
    {
        //$deleteForm = $this->createDeleteForm($actor);
        $editForm = $this->createForm('CineProject\PublicBundle\Form\MovieType', $movie);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('movie_edit', array('id' => $movie->getId()));
        }

        return $this->render('CineProjectPublicBundle:Movie:edit.html.twig', array(
            'movie' => $movie,
            'edit_form' => $editForm->createView(),
            // 'delete_form' => $deleteForm->createView(),
        ));
    }

}
