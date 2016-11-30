<?php

namespace CineProject\PublicBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * MovieRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class MovieRepository extends EntityRepository
{
//	public function findBestMovies() {
//		return $this->getEntityManager()->createQueryBuilder(
//			'SELECT m FROM CineProjectPublicBundle:Movie m
//			ORDER BY m.grade DESC
//			')
//			->setFirstResult(0)
//			->setMaxResults(5)
//			->getResult();
//	}

	public function findBestMovies() {
		return $this
//			->getEntityManager()
//			->createQueryBuilder()
//			->select('a')
//			->from('OCPlatformBundle:Advert', 'a')
			->createQueryBuilder('m') // shortcut
			->orderBy('m.grade', 'DESC')
			->setFirstResult(0)
			->setMaxResults(5)
			->getQuery()
			->getResult();
	}

	public function search($search)
	{
		$results = [];
		$movies = $this->getEntityManager()->createQuery(
			'SELECT m
             FROM CineProjectPublicBundle:Movie m
             WHERE m.title LIKE :search'
		)
			->setParameter('search', '%'.$search.'%')
			->getResult();

//		return $this
//			->createQueryBuilder('m')
//			->where('m.title LIKE :search')
//			->setParameter('search', '%'.$search.'%')
//			->getQuery()
//			->getResult();

		$results['movies'] = $movies;

		$actors = $this->getEntityManager()->createQuery(
			'SELECT a
             FROM CineProjectPublicBundle:Actor a
             WHERE a.firstName LIKE :search
             OR a.lastName LIKE :search'
		)
			->setParameter('search', '%'.$search.'%')
			->getResult();

		$results['actors'] = $actors;

		$directors = $this->getEntityManager()->createQuery(
			'SELECT d
             FROM CineProjectPublicBundle:Director d
             WHERE d.firstName LIKE :search
             OR d.lastName LIKE :search'
		)
			->setParameter('search', '%'.$search.'%')
			->getResult();

		$results['directors'] = $directors;

		return $results;
	}
}