<?php

namespace CineProject\PublicBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * ActorRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ActorRepository extends EntityRepository
{
	public function findActorWithMovies($id) {
		$result = $this
			->createQueryBuilder('a')
			->addSelect('m')
			->join('a.movies', 'm', 'WITH', 'a.id = :id')
			->setParameter('id', $id)
			->getQuery()
			->getResult(); // Error with getSingleResult() if there is no associated movie to the actor.

		return ($result !== [] ? $result[0] : false);
	}

}
