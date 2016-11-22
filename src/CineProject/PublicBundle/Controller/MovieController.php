<?php

namespace CineProject\PublicBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MovieController extends Controller
{
    public function displayAllAction()
    {
        $em = $this->getDoctrine()->getManager();
        $movies = $em->getRepository('CineProjectPublicBundle:Movie')->findAll();

        return $this->render('CineProjectPublicBundle:Movie:displayAll.html.twig', array('movies' => $movies));
    }
}
