<?php

namespace OC\PlatformBundle\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use OC\PlatformBundle\Entity\Picture;
use OC\PlatformBundle\Entity\Taxref;
use OC\PlatformBundle\Entity\User;

/**
 * Picture
 *
 * @ORM\Table(name="observation")
 * @ORM\Entity(repositoryClass="OC\PlatformBundle\Repository\ObservationRepository")
 */
class Observation
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
     * @var float
     *
     * @ORM\Column(name="latitude", type="float")
     */
    private $latitude;

    /**
     * @var float
     *
     * @ORM\Column(name="longitude", type="float")
     */
    private $longitude;

    /**
    * @ORM\OneToOne(targetEntity="OC\PlatformBundle\Entity\Picture", cascade={"persist", "remove"})
    */
    private $picture;

    /**
    * @ORM\ManyToOne(targetEntity="OC\PlatformBundle\Entity\Taxref")
    * @ORM\JoinColumn(nullable=false)
    */
    private $taxref;

    /**
    * @ORM\ManyToOne(targetEntity="OC\PlatformBundle\Entity\User", inversedBy="observations")
    * @ORM\JoinColumn(nullable=false)
    */
    private $user;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var bool
     *
     * @ORM\Column(name="validated", type="boolean")
     */
    private $validated;

    /**
     * @var bool
     *
     * @ORM\Column(name="flying", type="boolean")
     */
    private $flying;

    /**
     * @var string
     *
     * @ORM\Column(name="comment", type="text", nullable=true)
     */
    private $comment;

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
     * Set latitude
     *
     * @param integer $latitude
     *
     * @return Observation
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * Get latitude
     *
     * @return integer
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Set longitude
     *
     * @param integer $longitude
     *
     * @return Observation
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * Get longitude
     *
     * @return integer
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * Set picture
     *
     * @param Picture $picture
     *
     * @return Observation
     */
    public function setPicture(Picture $picture = null)
    {
        $this->picture = $picture;

        return $this;
    }

    /**
     * Get picture
     *
     * @return Picture
     */
    public function getPicture()
    {
        return $this->picture;
    }

    /**
     * Set taxref
     *
     * @param Taxref $taxref
     *
     * @return Observation
     */
    public function setTaxref(Taxref $taxref)
    {
        $this->taxref = $taxref;

        return $this;
    }

    /**
     * Get taxref
     *
     * @return Taxref
     */
    public function getTaxref()
    {
        return $this->taxref;
    }

    /**
     * Set user
     *
     * @param User $user
     *
     * @return Observation
     */
    public function setUser(User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set date
     *
     * @param DateTime $date
     *
     * @return Observation
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set validated
     *
     * @param boolean $validated
     *
     * @return Observation
     */
    public function setValidated($validated)
    {
        $this->validated = $validated;

        return $this;
    }

    /**
     * Get validated
     *
     * @return boolean
     */
    public function getValidated()
    {
        return $this->validated;
    }

    /**
     * Set flying
     *
     * @param boolean $flying
     *
     * @return Observation
     */
    public function setFlying($flying)
    {
        $this->flying = $flying;

        return $this;
    }

    /**
     * Get flying
     *
     * @return bool
     */
    public function getFlying()
    {
        return $this->flying;
    }

    /**
     * Set comment
     *
     * @param string $comment
     *
     * @return Observation
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get comment
     *
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

}
