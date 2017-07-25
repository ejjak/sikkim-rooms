<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Banner
 *
 * @ORM\Table(name="banner")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\BannerRepository")
 */
class Banner
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
     * @ORM\Column(name="imageurl", type="string", length=255)
     */
    private $imageurl;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set imageurl
     *
     * @param string $imageurl
     *
     * @return Banner
     */
    public function setImageurl($imageurl)
    {
        $this->imageurl = $imageurl;

        return $this;
    }

    /**
     * Get imageurl
     *
     * @return string
     */
    public function getImageurl()
    {
        return $this->imageurl;
    }
}

