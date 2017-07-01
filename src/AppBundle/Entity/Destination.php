<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Destination
 *
 * @ORM\Table(name="destination")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DestinationRepository")
 */
class Destination
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
     * @Assert\NotBlank(message="Please provide Destination Name.")
     * @ORM\Column(name="destinationName", type="string", length=255)
     */
    private $destinationName;

    /**
     * @var int
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Hotel", mappedBy="destination")
     */
    private $hotel;
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
     * Set destinationName
     *
     * @param string $destinationName
     *
     * @return Destination
     */
    public function setDestinationName($destinationName)
    {
        $this->destinationName = $destinationName;

        return $this;
    }

    /**
     * Get destinationName
     *
     * @return string
     */
    public function getDestinationName()
    {
        return $this->destinationName;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->hotel = new ArrayCollection();
    }

    /**
     * Add hotel
     *
     * @param \AppBundle\Entity\Hotel $hotel
     *
     * @return Destination
     */
    public function addHotel(\AppBundle\Entity\Hotel $hotel)
    {
        $this->hotel[] = $hotel;

        return $this;
    }

    /**
     * Remove hotel
     *
     * @param \AppBundle\Entity\Hotel $hotel
     */
    public function removeHotel(\AppBundle\Entity\Hotel $hotel)
    {
        $this->hotel->removeElement($hotel);
    }

    /**
     * Get hotel
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getHotel()
    {
        return $this->hotel;
    }

    public function __toString()
    {
        return $this->getDestinationName();
    }
}
