<?php

namespace CineProject\PublicBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Movie
 *
 * @ORM\Table(name="movie")
 * @ORM\Entity(repositoryClass="CineProject\PublicBundle\Repository\MovieRepository")
 */
class Movie
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
     * @Assert\NotBlank(message = "Vous devez saisir un titre")
     * @Assert\Length(
     *  min = 5,
     *  max = 50,
     *  minMessage = "Your first name must be at least {{ limit }} characters long",
     *  maxMessage = "Your first name cannot be longer than {{ limit }} characters"
     * )
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="release_date", type="datetime")
     */
    private $releaseDate;

    /**
     * @var boolean
     *
     * @ORM\Column(name="visible", type="boolean")
     */
    private $visible;

    /**
     * @ORM\ManyToMany(targetEntity="CineProject\PublicBundle\Entity\Actor", inversedBy="movies")
     */
    private $actors;

    /**
     * @var integer
     * @ORM\Column(name="grade", type="integer", nullable=true)
     */
    private $grade;

    /**
     * @ORM\ManyToOne(targetEntity="CineProject\PublicBundle\Entity\Category", inversedBy="movies")
     */
    private $category;

    public function __construct()
    {
        $this->actors = new ArrayCollection();
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
     * Set title
     *
     * @param string $title
     * @return Movie
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Movie
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set releaseDate
     *
     * @param \DateTime $releaseDate
     * @return Movie
     */
    public function setReleaseDate($releaseDate)
    {
        $this->releaseDate = $releaseDate;

        return $this;
    }

    /**
     * Get releaseDate
     *
     * @return \DateTime 
     */
    public function getReleaseDate()
    {
        return $this->releaseDate;
    }

    /**
     * Set visible
     *
     * @param boolean $visible
     * @return Movie
     */
    public function setVisible($visible)
    {
        $this->visible = $visible;

        return $this;
    }

    /**
     * Get visible
     *
     * @return boolean 
     */
    public function getVisible()
    {
        return $this->visible;
    }

    /**
     * Add actors
     *
     * @param \CineProject\PublicBundle\Entity\Actor $actors
     * @return Movie
     */
    public function addActor(\CineProject\PublicBundle\Entity\Actor $actors)
    {
        $this->actors[] = $actors;

        return $this;
    }

    /**
     * Remove actors
     *
     * @param \CineProject\PublicBundle\Entity\Actor $actors
     */
    public function removeActor(\CineProject\PublicBundle\Entity\Actor $actors)
    {
        $this->actors->removeElement($actors);
    }

    /**
     * Get actors
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getActors()
    {
        return $this->actors;
    }

    /**
     * Set grade
     *
     * @param integer $grade
     * @return Movie
     */
    public function setGrade($grade)
    {
        $this->grade = $grade;

        return $this;
    }

    /**
     * Get grade
     *
     * @return integer 
     */
    public function getGrade()
    {
        return $this->grade;
    }

    /**
     * Set category
     *
     * @param \CineProject\PublicBundle\Entity\Category $category
     * @return Movie
     */
    public function setCategory(\CineProject\PublicBundle\Entity\Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \CineProject\PublicBundle\Entity\Category 
     */
    public function getCategory()
    {
        return $this->category;
    }
}
