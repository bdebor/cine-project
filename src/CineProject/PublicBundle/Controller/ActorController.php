<?php

namespace CineProject\PublicBundle\Controller;

use CineProject\PublicBundle\Entity\Actor;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Actor controller.
 *
 */
class ActorController extends Controller
{
    /**
     * Lists all actor entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $actors = $em->getRepository('CineProjectPublicBundle:Actor')->findAll();

        return $this->render('CineProjectPublicBundle:Actor:index.html.twig', array(
            'actors' => $actors,
        ));
    }

    /**
     * Creates a new actor entity.
     *
     */
    public function newAction(Request $request)
    {
        $actor = new Actor();
        $form = $this->createForm('CineProject\PublicBundle\Form\ActorType', $actor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($actor);

            $fMovies = $form->getData()->getMovies();
            foreach($fMovies as $fMovie){
                $fMovie->addActor($actor);
            }

            $em->flush();

            return $this->redirectToRoute('actor_show', array('slug' => $actor->getSlug()));
        }

        return $this->render('CineProjectPublicBundle:Actor:new.html.twig', array(
            'actor' => $actor,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a actor entity.
     *
     */
    public function showAction(Actor $actor)
    {
        $deleteForm = $this->createDeleteForm($actor);

        return $this->render('CineProjectPublicBundle:Actor:show.html.twig', array(
            'actor' => $actor,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing actor entity.
     *
     */
    public function editAction(Request $request, Actor $actor)
    {
        $em = $this->getDoctrine()->getManager();

        $ActorWithFilms = $em->getRepository('CineProjectPublicBundle:Actor')->findActorWithFilms($actor->getId()); // Because $actor

        $moviesToRemove = [];
        if($ActorWithFilms){
            foreach($ActorWithFilms->getMovies() as $movie) {
                $moviesToRemove[] = $movie;
            }
        }

        $deleteForm = $this->createDeleteForm($actor);

        $editForm = $this->createForm('CineProject\PublicBundle\Form\ActorType', $actor);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em->persist($actor);

            $fMovies = $editForm->getData()->getMovies();

            foreach($fMovies as $fMovie){
                $moviesIsAlreadyPresent = false;

                foreach($moviesToRemove as $index => $movieToRemove){
                    if($fMovie === $movieToRemove){
                        $moviesIsAlreadyPresent = true;
                        unset($moviesToRemove[$index]);
                        break;
                    }
                }
                if($moviesIsAlreadyPresent === false){
                    $fMovie->addActor($actor);
                }
                foreach($moviesToRemove as $movieToRemove){
                    $movieToRemove->removeActor($actor);
                }
            }
            $em->flush();

            return $this->redirectToRoute('actor_edit', array('slug' => $actor->getSlug()));
        }

        return $this->render('CineProjectPublicBundle:Actor:edit.html.twig', array(
            'actor' => $actor,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a actor entity.
     *
     */
    public function deleteAction(Request $request, Actor $actor)
    {
        $form = $this->createDeleteForm($actor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($actor);
            $em->flush($actor);
        }

        return $this->redirectToRoute('actor_index');
    }

    /**
     * Creates a form to delete a actor entity.
     *
     * @param Actor $actor The actor entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Actor $actor)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('actor_delete', array('id' => $actor->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
