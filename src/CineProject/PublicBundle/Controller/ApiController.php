<?php

namespace CineProject\PublicBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class ApiController extends Controller
{
    public function testAction()
    {
        $em = $this->getDoctrine()->getManager();
        $movie = $em->getRepository('CineProjectPublicBundle:Movie')->findOneByVisible(true);

		$response = array(
			'id' => $movie->getId(),
			'title' => $movie->getTitle(),
			'description' => $movie->getDescription(),
			'releaseDate' => $movie->getReleaseDate(),
			'grade' => $movie->getGrade()
		);

        return new JsonResponse($response);
    }
}
