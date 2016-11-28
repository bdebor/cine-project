<?php

namespace CineProject\PublicBundle\Controller;

use CineProject\PublicBundle\Entity\Movie;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class MovieController extends Controller
{
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        // $movies = $em->getRepository('CineProjectPublicBundle:Movie')->findByVisible(true);

        /**/ // pagination with KnpPaginatorBundle
        $dql   = "SELECT m FROM CineProjectPublicBundle:Movie m WHERE m.visible = true";
        $query = $em->createQuery($dql);

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1) /*page number*/,
            5 /*limit per page*/
        );
        /*/*/

        return $this->render('CineProjectPublicBundle:Movie:index.html.twig', array('movies' => $pagination));
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
