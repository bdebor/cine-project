<?php

namespace CineProject\PublicBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class TestController extends Controller
{
    public function translationAction()
    {
        return $this->render('CineProjectPublicBundle:Test:translation.html.twig');
    }
}
