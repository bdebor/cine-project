<?php

namespace CineProject\PublicBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AbstractController extends Controller
{
    public function pagination($query, $limit = 5) // pagination with KnpPaginatorBundle
    {
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $this->get('request')->query->get('page', 1), /*page number*/
            $limit /*limit per page*/
        );
        return $pagination;
    }
}
