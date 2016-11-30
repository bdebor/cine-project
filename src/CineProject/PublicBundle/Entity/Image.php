<?php

namespace CineProject\PublicBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile; // not used ???

/**
 * Image
 *
 * @ORM\Table(name="image")
 * @ORM\Entity(repositoryClass="CineProject\PublicBundle\Repository\ImageRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Image
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="folder", type="string", length=255)
     */
    private $folder = 'actor';

    private $oldName;


    /**
     * @Assert\File(
     *      mimeTypes = {"image/jpg","image/jpeg","image/tiff","image/png"},
     *      mimeTypesMessage = "Merci d'entrer une image valide",
     *      maxSize = "2048k",
     *      maxSizeMessage = "le fichier est trop lourd"
     * )
     */
    private $file;

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
     * Set name
     *
     * @param string $name
     * @return Image
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    public function setFile($file)
    {
        $this->file = $file ;
        if (null !== $this->name) {
            $this->oldName = $this->name ;
            $this->name = null ;
        } else {
            $this->name = ' '; // ???
        }
        return $this;
    }

    public function getFile()
    {
        return $this->file ;
    }

    public function setOldName($name)
    {
        $this->oldName = $name;
        return $this ;
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        if (null !== $this->file) {
            $this->name = $this->file->getClientOriginalName() ;
        }
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    {
        if (null === $this->file) {
            return false ;
        }

        if (null !== $this->oldName) {
            if(file_exists($this->getAbsoluteOldPath()))
            {
                unlink($this->getAbsoluteOldPath()) ;
            }
        }

        $this->name = $this->id.'_'.$this->file->getClientOriginalName() ;
        $this->file->move($this->getUploadRootDir(),$this->name);
        $this->file = null ;
    }

    /**
     * @ORM\PreRemove()
     *
     */
    public function removeFile()
    {
        $file = $this->getAbsolutePath() ;
        if (file_exists($file)) {
            unlink($file) ;
        }
    }

    public function getUploadRootDir()
    {
        return __DIR__.'/../../../../web/'.$this->getUploadDir() ;
    }

    public function getUploadDir()
    {
        return 'upload/img/'.$this->folder;
    }

    public function getWebPath()
    {
        if (null === $this->name) {
            return null ;
        } else {
            return $this->getUploadDir().'/'.$this->id.'_'.$this->name ;
        }
    }


    public function getAbsolutePath()
    {
        if ( null === $this->name) {
            return null ;
        } else {
            return $this->getUploadRootDir().'/'.$this->id.'_'.$this->name ;
        }
    }

    public function getAbsoluteOldPath()
    {
        if (null === $this->oldName) {
            return null ;
        } else {
            return $this->getUploadRootDir().'/'.$this->id.'_'.$this->oldName ;
        }
    }

    /**
     * Set folder
     *
     * @param string $folder
     * @return Image
     */
    public function setFolder($folder)
    {
        $this->folder = $folder;

        return $this;
    }

    /**
     * Get folder
     *
     * @return string 
     */
    public function getFolder()
    {
        return $this->folder;
    }
}
