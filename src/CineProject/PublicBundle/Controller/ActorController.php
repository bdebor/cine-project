<?php

namespace CineProject\PublicBundle\Controller;

use CineProject\PublicBundle\Entity\Actor;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Actor controller.
 *
 */
class ActorController extends AbstractController
{
    /**
     * Lists all actor entities.
     *
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        /**/ // pagination with KnpPaginatorBundle
        $dql = "SELECT a FROM CineProjectPublicBundle:Actor a";
        $query = $em->createQuery($dql);
        $pagination = $this->pagination($query, 5);
        /*/*/

        /**/ // breadcrumb with WhiteOctoberBreadcrumbsBundle
        $pages = array();
        $pages['Acteurs'] = "";
        $this->breadcrumb($pages);
        /*/*/

        return $this->render('CineProjectPublicBundle:Actor:index.html.twig', array(
            'actors' => $pagination,
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

            foreach($actor->getMovies() as $movie){
                $movie->addActor($actor);
            }

            $em->flush();

            return $this->redirectToRoute('actor_show', array('slug' => $actor->getSlug()));
        }

        /**/ // breadcrumb with WhiteOctoberBreadcrumbsBundle
        $pages = array();
        $pages['Acteurs'] = "actor_index";
        $pages['Ajouter'] = "";
        $this->breadcrumb($pages);
        /**/

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

        /**/ // breadcrumb with WhiteOctoberBreadcrumbsBundle
        $pages = array();
        $pages['Acteurs'] = "actor_index";
        $pages[$actor->getFullName()] = "";
        $this->breadcrumb($pages);
        /**/

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
        $moviesToRemove = [];
        foreach($actor->getMovies() as $movie) {
            $moviesToRemove[] = $movie;
        }

        $deleteForm = $this->createDeleteForm($actor);

        $editForm = $this->createForm('CineProject\PublicBundle\Form\ActorType', $actor);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($actor);

            foreach($actor->getMovies() as $movie){
                $moviesIsAlreadyPresent = false;

                foreach($moviesToRemove as $index => $movieToRemove){
                    if($movie === $movieToRemove){
                        $moviesIsAlreadyPresent = true;
                        unset($moviesToRemove[$index]);
                        break;
                    }
                }
                if($moviesIsAlreadyPresent === false){
                    $movie->addActor($actor);
                }
                foreach($moviesToRemove as $movieToRemove){
                    $movieToRemove->removeActor($actor);
                }
            }
            $em->flush();

            return $this->redirectToRoute('actor_edit', array('slug' => $actor->getSlug()));
        }

        /**/ // breadcrumb with WhiteOctoberBreadcrumbsBundle
        $pages = array();
        $pages['Acteurs'] = "actor_index";
        $pages['Modifier '.$actor->getFullName()] = "";
        $this->breadcrumb($pages);
        /**/

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
            $em->flush();
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
