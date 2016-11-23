<?php

namespace CineProject\PublicBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $bestMovies = $em->getRepository('CineProjectPublicBundle:Movie')->findBestMovies();
        return $this->render('CineProjectPublicBundle:Default:index.html.twig', array('bestMovies' => $bestMovies));
    }
}
