<?php

namespace CineProject\PublicBundle\Controller;

use CineProject\PublicBundle\Entity\Cinema;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Cinema controller.
 *
 */
class CinemaController extends Controller
{
    /**
     * Lists all cinema entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $cinemas = $em->getRepository('CineProjectPublicBundle:Cinema')->findAll();

        return $this->render('CineProjectPublicBundle:Cinema:index.html.twig', array(
            'cinemas' => $cinemas,
        ));
    }

    /**
     * Creates a new cinema entity.
     *
     */
    public function newAction(Request $request)
    {
        $cinema = new Cinema();
        $form = $this->createForm('CineProject\PublicBundle\Form\CinemaType', $cinema);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($cinema);
            $em->flush($cinema);

            return $this->redirectToRoute('cinema_show', array('id' => $cinema->getId()));
        }

        return $this->render('CineProjectPublicBundle:Cinema:new.html.twig', array(
            'cinema' => $cinema,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a cinema entity.
     *
     */
    public function showAction(Cinema $cinema)
    {
        $deleteForm = $this->createDeleteForm($cinema);

        return $this->render('CineProjectPublicBundle:Cinema:show.html.twig', array(
            'cinema' => $cinema,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing cinema entity.
     *
     */
    public function editAction(Request $request, Cinema $cinema)
    {
        $deleteForm = $this->createDeleteForm($cinema);
        $editForm = $this->createForm('CineProject\PublicBundle\Form\CinemaType', $cinema);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('cinema_edit', array('id' => $cinema->getId()));
        }

        return $this->render('CineProjectPublicBundle:Cinema:edit.html.twig', array(
            'cinema' => $cinema,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a cinema entity.
     *
     */
    public function deleteAction(Request $request, Cinema $cinema)
    {
        $form = $this->createDeleteForm($cinema);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($cinema);
            $em->flush($cinema);
        }

        return $this->redirectToRoute('cinema_index');
    }

    /**
     * Creates a form to delete a cinema entity.
     *
     * @param Cinema $cinema The cinema entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Cinema $cinema)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cinema_delete', array('id' => $cinema->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
