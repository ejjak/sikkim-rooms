<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Package
 *
 * @ORM\Table(name="package")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PackageRepository")
 */
class Package
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
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var int
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Images", mappedBy="package",cascade={"all"},orphanRemoval=true)
     */
    private $package_image;
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
     * Set title
     *
     * @param string $title
     *
     * @return Package
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
     * Constructor
     */
    public function __construct()
    {
        $this->package_image = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add packageImage
     *
     * @param \AppBundle\Entity\Images $packageImage
     *
     * @return Package
     */
    public function addPackageImage(\AppBundle\Entity\Images $packageImage)
    {
        $this->package_image[] = $packageImage;
        $packageImage->setPackage($this);
        return $this;
    }

    /**
     * Remove packageImage
     *
     * @param \AppBundle\Entity\Images $packageImage
     */
    public function removePackageImage(\AppBundle\Entity\Images $packageImage)
    {
        $this->package_image->removeElement($packageImage);
    }

    /**
     * Get packageImage
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPackageImage()
    {
        return $this->package_image;
    }
}
