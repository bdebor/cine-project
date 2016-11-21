<?php

namespace CineProject\PublicBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('CineProjectPublicBundle:Default:index.html.twig');
    }

    public function testAction($testNumber)
    {
        dump($testNumber);
        return $this->render('CineProjectPublicBundle:Default:index.html.twig');
    }
}
