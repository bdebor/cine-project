<?php

namespace CineProject\PublicBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Actor
 *
 * @ORM\Table(name="actor")
 * @ORM\Entity(repositoryClass="CineProject\PublicBundle\Repository\ActorRepository")
 */
class Actor
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
     * @var string
     *
     * @ORM\Column(name="first_name", type="string", length=255)
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="last_name", type="string", length=255)
     */
    private $lastName;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="birth_date", type="datetime")
     */
    private $birthDate;

    /**
     * @var string
     *
     * @ORM\Column(name="biography", type="text")
     */
    private $biography;

    /**
     * @ORM\ManyToMany(targetEntity="CineProject\PublicBundle\Entity\Movie", mappedBy="actors")
     */
    private $movies;

    /**
     * @ORM\OneToOne(targetEntity="CineProject\PublicBundle\Entity\Image", cascade={"persist", "remove"})
     */
    private $image;

    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=50)
     * @Gedmo\Slug(fields={"firstName","lastName"}, separator="-")
     */
    private $slug;


    public function __construct()
    {
        $this->movies = new ArrayCollection();
    }

    public function getFullName()
    {
        return $this->firstName.' '.$this->lastName;
    }

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
     * Set lastName
     *
     * @param string $lastName
     * @return Actor
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string 
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set birthDate
     *
     * @param \DateTime $birthDate
     * @return Actor
     */
    public function setBirthDate($birthDate)
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    /**
     * Get birthDate
     *
     * @return \DateTime 
     */
    public function getBirthDate()
    {
        return $this->birthDate;
    }

    /**
     * Set biography
     *
     * @param string $biography
     * @return Actor
     */
    public function setBiography($biography)
    {
        $this->biography = $biography;

        return $this;
    }

    /**
     * Get biography
     *
     * @return string 
     */
    public function getBiography()
    {
        return $this->biography;
    }

    /**
     * Add movies
     *
     * @param \CineProject\PublicBundle\Entity\Movie $movies
     * @return Actor
     */
    public function addMovie(\CineProject\PublicBundle\Entity\Movie $movies)
    {
        $this->movies[] = $movies;
        return $this;
    }

    /**
     * Remove movies
     *
     * @param \CineProject\PublicBundle\Entity\Movie $movies
     */
    public function removeMovie(\CineProject\PublicBundle\Entity\Movie $movies)
    {
        $this->movies->removeElement($movies);
    }

    /**
     * Get movies
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMovies()
    {
        return $this->movies;
    }

    /**
     * Set image
     *
     * @param \CineProject\PublicBundle\Entity\Image $image
     * @return Actor
     */
    public function setImage(\CineProject\PublicBundle\Entity\Image $image = null)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return \CineProject\PublicBundle\Entity\Image 
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return Actor
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string 
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set firstName
     *
     * @param string $firstName
     * @return Actor
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string 
     */
    public function getFirstName()
    {
        return $this->firstName;
    }
}
