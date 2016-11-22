<?php

namespace AppBundle\DataFixtures\ORM;

use CineProject\PublicBundle\Entity\Movie;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadData implements FixtureInterface
{
	public function load(ObjectManager $manager)
	{
		for ($i = 1; $i <= 10; $i++) {
			$movie = new Movie();
			$movie->setTitle("Pulp fiction $i");
			$movie->setDescription("Interdit aux moins de 12 ans \nL'odyssée sanglante et burlesque de petits malfrats dans la jungle de Hollywood à travers trois histoires qui s'entremêlent. ");
			$createdAt = new \DateTime( '1994/10/26' );
			$movie->setCreatedAt($createdAt);
			$movie->setIsActive(true);
			$manager->persist($movie);
		}
		$manager->flush();
	}
}