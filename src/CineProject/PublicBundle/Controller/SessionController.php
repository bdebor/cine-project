<?php

namespace CineProject\PublicBundle\Controller;

use CineProject\PublicBundle\Entity\Session;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Session controller.
 *
 */
class SessionController extends Controller
{
    /**
     * Lists all session entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $sessions = $em->getRepository('CineProjectPublicBundle:Session')->findAll();

        return $this->render('CineProjectPublicBundle:Session:index.html.twig', array(
            'sessions' => $sessions,
        ));
    }

    /**
     * Creates a new session entity.
     *
     */
    public function newAction(Request $request)
    {
        $session = new Session();
        $form = $this->createForm('CineProject\PublicBundle\Form\SessionType', $session);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($session);
            $em->flush($session);

            return $this->redirectToRoute('session_show', array('id' => $session->getId()));
        }

        return $this->render('CineProjectPublicBundle:Session:new.html.twig', array(
            'session' => $session,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a session entity.
     *
     */
    public function showAction(Session $session)
    {
        $deleteForm = $this->createDeleteForm($session);

        return $this->render('CineProjectPublicBundle:Session:show.html.twig', array(
            'session' => $session,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing session entity.
     *
     */
    public function editAction(Request $request, Session $session)
    {
        $deleteForm = $this->createDeleteForm($session);
        $editForm = $this->createForm('CineProject\PublicBundle\Form\SessionType', $session);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('session_edit', array('id' => $session->getId()));
        }

        return $this->render('CineProjectPublicBundle:Session:edit.html.twig', array(
            'session' => $session,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a session entity.
     *
     */
    public function deleteAction(Request $request, Session $session)
    {
        $form = $this->createDeleteForm($session);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($session);
            $em->flush($session);
        }

        return $this->redirectToRoute('session_index');
    }

    /**
     * Creates a form to delete a session entity.
     *
     * @param Session $session The session entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Session $session)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('session_delete', array('id' => $session->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
