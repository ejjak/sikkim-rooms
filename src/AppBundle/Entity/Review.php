<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Review
 *
 * @ORM\Table(name="review")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ReviewRepository")
 */
class Review
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
     *
     * @ORM\Column(name="average", type="integer")
     */
    private $average;

    /**
     * @var int
     *
     * @ORM\Column(name="good", type="integer")
     */
    private $good;

    /**
     * @var int
     *
     * @ORM\Column(name="excellent", type="integer")
     */
    private $excellent;

    /**
     * @var string
     *
     * @ORM\Column(name="uid", type="string", length=255)
     */
    private $uid;

    /**
     * @var int
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Hotel", inversedBy="reviews")
     *)
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
     * Set average
     *
     * @param integer $average
     *
     * @return Review
     */
    public function setAverage($average)
    {
        $this->average = $average;

        return $this;
    }

    /**
     * Get average
     *
     * @return int
     */
    public function getAverage()
    {
        return $this->average;
    }

    /**
     * Set good
     *
     * @param integer $good
     *
     * @return Review
     */
    public function setGood($good)
    {
        $this->good = $good;

        return $this;
    }

    /**
     * Get good
     *
     * @return int
     */
    public function getGood()
    {
        return $this->good;
    }

    /**
     * Set excellent
     *
     * @param integer $excellent
     *
     * @return Review
     */
    public function setExcellent($excellent)
    {
        $this->excellent = $excellent;

        return $this;
    }

    /**
     * Get excellent
     *
     * @return int
     */
    public function getExcellent()
    {
        return $this->excellent;
    }

    /**
     * Set uid
     *
     * @param string $uid
     *
     * @return Review
     */
    public function setUid($uid)
    {
        $this->uid = $uid;

        return $this;
    }

    /**
     * Get uid
     *
     * @return string
     */
    public function getUid()
    {
        return $this->uid;
    }

    /**
     * Set hotel
     *
     * @param \AppBundle\Entity\Hotel $hotel
     *
     * @return Review
     */
    public function setHotel(\AppBundle\Entity\Hotel $hotel = null)
    {
        $this->hotel = $hotel;

        return $this;
    }

    /**
     * Get hotel
     *
     * @return \AppBundle\Entity\Hotel
     */
    public function getHotel()
    {
        return $this->hotel;
    }
}
