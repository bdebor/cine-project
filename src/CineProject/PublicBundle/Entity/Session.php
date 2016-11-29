<?php

namespace CineProject\PublicBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Session
 *
 * @ORM\Table(name="session")
 * @ORM\Entity(repositoryClass="CineProject\PublicBundle\Repository\SessionRepository")
 */
class Session
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity="CineProject\PublicBundle\Entity\Movie")
     */
    private $movie;

    /**
     * @ORM\ManyToOne(targetEntity="CineProject\PublicBundle\Entity\Cinema")
     */
    private $cinema;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Session
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set movie
     *
     * @param \CineProject\PublicBundle\Entity\Movie $movie
     * @return Session
     */
    public function setMovie(\CineProject\PublicBundle\Entity\Movie $movie = null)
    {
        $this->movie = $movie;

        return $this;
    }

    /**
     * Get movie
     *
     * @return \CineProject\PublicBundle\Entity\Movie 
     */
    public function getMovie()
    {
        return $this->movie;
    }

    /**
     * Set cinema
     *
     * @param \CineProject\PublicBundle\Entity\Cinema $cinema
     * @return Session
     */
    public function setCinema(\CineProject\PublicBundle\Entity\Cinema $cinema = null)
    {
        $this->cinema = $cinema;

        return $this;
    }

    /**
     * Get cinema
     *
     * @return \CineProject\PublicBundle\Entity\Cinema 
     */
    public function getCinema()
    {
        return $this->cinema;
    }
}
