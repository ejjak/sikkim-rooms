<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Hotel
 *
 * @ORM\Table(name="hotel")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\HotelRepository")
 */
class Hotel
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
     * @var string
     *
     * @ORM\Column(name="address", type="text")
     */
    private $address;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=255)
     */
    private $phone;

    /**
     * @var string
     *
     * @ORM\Column(name="amenities", type="string", length=255)
     */
    private $amenities;

    /**
     * @var string
     *
     * @ORM\Column(name="gmap", type="text")
     */
    private $gmap;

    /**
     * @var string
     *
     * @ORM\Column(name="website", type="string", length=255)
     */
    private $website;

    /**
     * @var string
     *
     * @ORM\Column(name="priceRangeA", type="string", length=255)
     */
    private $priceRangeA;

    /**
     * @var string
     *
     * @ORM\Column(name="priceRangeB", type="string", length=255)
     */
    private $priceRangeB;

    /**
     * @var string
     *
     * @ORM\Column(name="star", type="string", length=255)
     */
    private $star;

    /**
     * @var string
     *
     * @ORM\Column(name="imageurl", type="string", length=255)
     */
    private $imageurl;


    /**
     * @var int
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Milestone", mappedBy="hotel",cascade={"all"},orphanRemoval=true)
     */
    private $milestone;

    /**
     * @var int
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Review", mappedBy="hotel",cascade={"all"},orphanRemoval=true)
     */
    private $reviews;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Destination",inversedBy="hotel")
     * @Assert\NotBlank()
     */
    protected $destination;
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
     * @return Hotel
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
     * Set address
     *
     * @param string $address
     *
     * @return Hotel
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Hotel
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set phone
     *
     * @param string $phone
     *
     * @return Hotel
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set amenities
     *
     * @param string $amenities
     *
     * @return Hotel
     */
    public function setAmenities($amenities)
    {
        $this->amenities = $amenities;

        return $this;
    }

    /**
     * Get amenities
     *
     * @return string
     */
    public function getAmenities()
    {
        return $this->amenities;
    }

    /**
     * Set gmap
     *
     * @param string $gmap
     *
     * @return Hotel
     */
    public function setGmap($gmap)
    {
        $this->gmap = $gmap;

        return $this;
    }

    /**
     * Get gmap
     *
     * @return string
     */
    public function getGmap()
    {
        return $this->gmap;
    }

    /**
     * Set website
     *
     * @param string $website
     *
     * @return Hotel
     */
    public function setWebsite($website)
    {
        $this->website = $website;

        return $this;
    }

    /**
     * Get website
     *
     * @return string
     */
    public function getWebsite()
    {
        return $this->website;
    }

    /**
     * Set priceRangeA
     *
     * @param string $priceRangeA
     *
     * @return Hotel
     */
    public function setPriceRangeA($priceRangeA)
    {
        $this->priceRangeA = $priceRangeA;

        return $this;
    }

    /**
     * Get priceRangeA
     *
     * @return string
     */
    public function getPriceRangeA()
    {
        return $this->priceRangeA;
    }

    /**
     * Set priceRangeB
     *
     * @param string $priceRangeB
     *
     * @return Hotel
     */
    public function setPriceRangeB($priceRangeB)
    {
        $this->priceRangeB = $priceRangeB;

        return $this;
    }

    /**
     * Get priceRangeB
     *
     * @return string
     */
    public function getPriceRangeB()
    {
        return $this->priceRangeB;
    }

    /**
     * Set star
     *
     * @param string $star
     *
     * @return Hotel
     */
    public function setStar($star)
    {
        $this->star = $star;

        return $this;
    }

    /**
     * Get star
     *
     * @return string
     */
    public function getStar()
    {
        return $this->star;
    }

    /**
     * Set imageurl
     *
     * @param string $imageurl
     *
     * @return Hotel
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
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->milestone = new ArrayCollection();
        $this->reviews = new ArrayCollection();
    }

    /**
     * Add milestone
     *
     * @param \AppBundle\Entity\Milestone $milestone
     *
     * @return Hotel
     */
    public function addMilestone(\AppBundle\Entity\Milestone $milestone)
    {
        $this->milestone[] = $milestone;
        $milestone->setHotel($this);
        return $this;
    }

    /**
     * Remove milestone
     *
     * @param \AppBundle\Entity\Milestone $milestone
     */
    public function removeMilestone(\AppBundle\Entity\Milestone $milestone)
    {
        $this->milestone->removeElement($milestone);
    }

    /**
     * Get milestone
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMilestone()
    {
        return $this->milestone;
    }

    /**
     * Add location
     *
     * @param \AppBundle\Entity\Destination $destination
     * @return Hotel
     */
    public function addLocation(Destination $destination)
    {
        $this->destination[] = $destination;
        return $this;
    }

    /**
     * Remove location
     *
     * @param \AppBundle\Entity\Destination $destination
     */
    public function removeLocation(Destination $destination)
    {
        $this->destination->removeElement($destination);
    }

    /**
     * Set destination
     *
     * @param \AppBundle\Entity\Destination $destination
     *
     * @return Hotel
     */
    public function setDestination(\AppBundle\Entity\Destination $destination = null)
    {
        $this->destination = $destination;

        return $this;
    }

    /**
     * Get destination
     *
     * @return \AppBundle\Entity\Destination
     */
    public function getDestination()
    {
        return $this->destination;
    }
    /**
     * @var date $created
     *
     * @ORM\Column(name="created", type="datetime", nullable=true)
     */
    protected $created;
    /**
     * @var date $updated
     *
     * @ORM\Column(name="updated", type="datetime", nullable=true)
     */
    protected $modified;

    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return Hotel
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set modified
     *
     * @param \DateTime $modified
     *
     * @return Hotel
     */
    public function setModified($modified)
    {
        $this->modified = $modified;

        return $this;
    }

    /**
     * Get modified
     *
     * @return \DateTime
     */
    public function getModified()
    {
        return $this->modified;
    }

    /**
     * Triggered on insert
     * @ORM\PrePersist
     */
    public function onPrePersist()
    {
        $this->created = new \DateTime("now");
    }
    /**
     * Triggered on update
     * @ORM\PreUpdate
     */
    public function onPreUpdate()
    {
        $this->modified = new \DateTime("now");
    }

    /**
     * Add review
     *
     * @param \AppBundle\Entity\Review $review
     *
     * @return Hotel
     */
    public function addReview(\AppBundle\Entity\Review $review)
    {
        $this->reviews[] = $review;

        return $this;
    }

    /**
     * Remove review
     *
     * @param \AppBundle\Entity\Review $review
     */
    public function removeReview(\AppBundle\Entity\Review $review)
    {
        $this->reviews->removeElement($review);
    }

    /**
     * Get reviews
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getReviews()
    {
        return $this->reviews;
    }
}
