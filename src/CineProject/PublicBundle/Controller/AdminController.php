<?php

namespace CineProject\PublicBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminController extends Controller
{
    public function indexAction()
    {
        return $this->render('CineProjectPublicBundle:Admin:index.html.twig');
    }
}
