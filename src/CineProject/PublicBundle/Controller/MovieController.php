<?php

namespace CineProject\PublicBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MovieController extends Controller
{
    public function displayAllAction()
    {
        $em = $this->getDoctrine()->getManager();
        $movies = $em->getRepository('CineProjectPublicBundle:Movie')->findByIsActive(1);

        return $this->render('CineProjectPublicBundle:Movie:displayAll.html.twig', array('movies' => $movies));
    }
}
