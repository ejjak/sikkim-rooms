<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Advert
 *
 * @ORM\Table(name="advert")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AdvertRepository")
 */
class Advert
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
     * @var int
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Images", mappedBy="advert",cascade={"all"},orphanRemoval=true)
     */
    private $advert_image;


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
     * Constructor
     */
    public function __construct()
    {
        $this->advert_image = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add advertImage
     *
     * @param \AppBundle\Entity\Images $advertImage
     *
     * @return Advert
     */
    public function addAdvertImage(\AppBundle\Entity\Images $advertImage)
    {
        $this->advert_image[] = $advertImage;
        $advertImage->setAdvert($this);
        return $this;
    }

    /**
     * Remove advertImage
     *
     * @param \AppBundle\Entity\Images $advertImage
     */
    public function removeAdvertImage(\AppBundle\Entity\Images $advertImage)
    {
        $this->advert_image->removeElement($advertImage);
    }

    /**
     * Get advertImage
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAdvertImage()
    {
        return $this->advert_image;
    }
}
