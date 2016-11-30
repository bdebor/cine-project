<?php

namespace CineProject\PublicBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

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

    private $thumbnails = array('small' => array(200,200), 'medium' => array(400,400), 'large' => array(600,600));

    /**
     * @Assert\File(
     *      mimeTypes = {"image/jpg","image/jpeg","image/tiff","image/png"},
     *      mimeTypesMessage = "Merci d'entrer une image valide",
     *      maxSize = "2048k",
     *      maxSizeMessage = "le fichier est trop lourd"
     * )
     *
     * @var UploadedFile
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

        /**/ // thumbnails with the package Imagine
        foreach ($this->thumbnails as $key => $value)
        {
            $file = $this->getUploadRootDir() . '/' . $this->getId() . '_' . $key . '_' . $this->oldName;
            if (file_exists($file)) {
                unlink($file);
            }
        }

        $this->name = $this->file->getClientOriginalName();
        foreach ($this->thumbnails as $key => $value){
            $imagine = new \Imagine\Gd\Imagine();
            $imagine
                ->open($this->getAbsolutePath())
                ->thumbnail(new\Imagine\Image\Box($value[0],$value[1]))
                ->save(
                    $this->getUploadDir() . '/'. $this->getId() . '_'. $key .'_' . $this->name, array('quality' => 80)
                );
        }
        /*/*/

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

        foreach ($this->thumbnails as $key => $value) // thumbnails
        {
            $file = $this->getUploadRootDir().'/'.$this->getId().'_'.$key.'_'.$this->name;
            if (file_exists($file))
            {
                unlink($file);
            }
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

    public function getWebPath($thumbnail = null)
    {
        if (null === $this->name) {
            return null ;
        } else {
            $name = $this->name;
            if ($thumbnail) {
                $tmpthumbnail = $this->getId().'_'.$thumbnail.'_'.$name;
                if (file_exists($this->getUploadDir().'/'.$tmpthumbnail)) {
                    $name = $tmpthumbnail;
                } else {
                    $name = $this->getId().'_'.$name;
                }
            } else {
                $name = $this->id.'_'.$name;
            }
            return $this->getUploadDir().'/'.$name;
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
