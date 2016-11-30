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

    public function breadcrumb($pages = null) // breadcrumb with WhiteOctoberBreadcrumbsBundle
    {
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Home", $this->generateUrl('cine_project_public_homepage'));

        if (isset($pages)) {
            foreach ($pages as $key => $value){
                if ($value != '') {
                    $breadcrumbs->addItem($key, $this->generateUrl($value));
                } else {
                    $breadcrumbs->addItem($key);
                }
            }
        }
    }
}
