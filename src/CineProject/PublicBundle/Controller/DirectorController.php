<?php

namespace CineProject\PublicBundle\Controller;

use CineProject\PublicBundle\Entity\Director;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Director controller.
 *
 */
class DirectorController extends Controller
{
    /**
     * Lists all director entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $directors = $em->getRepository('CineProjectPublicBundle:Director')->findAll();

        return $this->render('CineProjectPublicBundle:Director:index.html.twig', array(
            'directors' => $directors,
        ));
    }

    /**
     * Creates a new director entity.
     *
     */
    public function newAction(Request $request)
    {
        $director = new Director();
        $form = $this->createForm('CineProject\PublicBundle\Form\DirectorType', $director);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($director);
            $em->flush($director);

            return $this->redirectToRoute('director_show', array('id' => $director->getId()));
        }

        return $this->render('CineProjectPublicBundle:Director:new.html.twig', array(
            'director' => $director,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a director entity.
     *
     */
    public function showAction(Director $director)
    {
        $deleteForm = $this->createDeleteForm($director);

        return $this->render('CineProjectPublicBundle:Director:show.html.twig', array(
            'director' => $director,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing director entity.
     *
     */
    public function editAction(Request $request, Director $director)
    {
        $deleteForm = $this->createDeleteForm($director);
        $editForm = $this->createForm('CineProject\PublicBundle\Form\DirectorType', $director);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('director_edit', array('id' => $director->getId()));
        }

        return $this->render('CineProjectPublicBundle:Director:edit.html.twig', array(
            'director' => $director,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a director entity.
     *
     */
    public function deleteAction(Request $request, Director $director)
    {
        $form = $this->createDeleteForm($director);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($director);
            $em->flush($director);
        }

        return $this->redirectToRoute('director_index');
    }

    /**
     * Creates a form to delete a director entity.
     *
     * @param Director $director The director entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Director $director)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('director_delete', array('id' => $director->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
