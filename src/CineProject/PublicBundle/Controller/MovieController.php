<?php

namespace CineProject\PublicBundle\Controller;

use CineProject\PublicBundle\Entity\Movie;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class MovieController extends AbstractController
{
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        /**/ // pagination with KnpPaginatorBundle
        $dql = "SELECT m FROM CineProjectPublicBundle:Movie m WHERE m.visible = true";
        $query = $em->createQuery($dql);
        $pagination = $this->pagination($query, 5);
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
        $em = $this->getDoctrine()->getManager();
        $sessions = $em->getRepository('CineProjectPublicBundle:Session')->findByMovie($movie);

        $deleteForm = $this->createDeleteForm($movie);
        return $this->render('CineProjectPublicBundle:Movie:show.html.twig', array(
            'movie' => $movie,
            'delete_form' => $deleteForm->createView(),
            'sessions' => $sessions
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
        if ($request->isXmlHttpRequest()){
            $em = $this->getDoctrine()->getManager();
            $em->remove($movie);
            $em->flush();
            return new JsonResponse(true);
        }else{
            $form = $this->createDeleteForm($movie);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->remove($movie);
                $em->flush();
            }

            return $this->redirectToRoute('movie_index');
        }
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

    public function favoriteAction(Request $request, $id)
    {
        $session = $request->getSession();
        $favorites = $session->get('favorites');

        if ($favorites && in_array($id, $favorites)) {
            $key = array_search($id, $favorites);
            unset($favorites[$key]);
        } else {
            $favorites[] = $id;
        }
        //var_dump($favorites);
        $session->set('favorites', $favorites);

        return new JsonResponse($favorites);
    }
}
