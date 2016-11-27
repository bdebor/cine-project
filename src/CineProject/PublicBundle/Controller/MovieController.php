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
        $movies = $em->getRepository('CineProjectPublicBundle:Movie')->findByVisible(true);

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
            $em->flush();

            return $this->redirectToRoute('movie_show', array('id' => $movie->getId()));
        }

        return $this->render('CineProjectPublicBundle:Movie:new.html.twig', array(
            'movie' => $movie,
            'form' => $form->createView(),
        ));
    }

    public function showAction(Movie $movie)
    {
        $deleteForm = $this->createDeleteForm($movie);
        return $this->render('CineProjectPublicBundle:Movie:show.html.twig', array(
            'movie' => $movie,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    public function editAction(Request $request, Movie $movie)
    {
        $deleteForm = $this->createDeleteForm($movie);
        $editForm = $this->createForm('CineProject\PublicBundle\Form\MovieType', $movie);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($movie);
            $em->flush();

            return $this->redirectToRoute('movie_edit', array('id' => $movie->getId()));
        }

        return $this->render('CineProjectPublicBundle:Movie:edit.html.twig', array(
            'movie' => $movie,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    public function deleteAction(Request $request, Movie $movie)
    {
        $form = $this->createDeleteForm($movie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($movie);
            $em->flush();
        }

        return $this->redirectToRoute('movie_index');
    }

//    public function deleteAction(Movie $movie)
//    {
//        $em = $this->getDoctrine()->getManager();
//        $em->remove($movie);
//        $em->flush($movie);
//
//        return $this->redirectToRoute('movie_index');
//    }
//
//    public function deleteAction($movieId)
//    {
//        $em = $this->getDoctrine()->getManager();
//        $movie = $em->getRepository('CineProjectPublicBundle:Movie')->find($movieId);
//        $em->remove($movie);
//        $em->flush($movie);
//
//        return $this->redirectToRoute('movie_index');
//    }


    private function createDeleteForm(Movie $movie) // ???
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('movie_delete', array('id' => $movie->getId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }
}
