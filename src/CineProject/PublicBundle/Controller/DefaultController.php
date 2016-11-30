<?php

namespace CineProject\PublicBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $bestMovies = $em->getRepository('CineProjectPublicBundle:Movie')->findBestMovies();
        return $this->render('CineProjectPublicBundle:Default:index.html.twig', array('bestMovies' => $bestMovies));
    }

    public function searchAction(Request $request)
    {
        $results = null;

        $search = $request->query->get('req'); // $_GET
        if($search){
            $em = $this->getDoctrine()->getManager();
            $results = $em->getRepository('CineProjectPublicBundle:Movie')->search($search);
        }

        return $this->render('CineProjectPublicBundle:Default:search.html.twig', array(
            'results' => $results,
            'search' => $search
        ));

    }
}
