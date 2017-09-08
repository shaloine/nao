<?php

namespace OC\PlatformBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
    * @ORM\OneToOne(targetEntity="OC\PlatformBundle\Entity\Picture", cascade={"persist"})
    */
    private $picture;

    /**
    * @ORM\OneToOne(targetEntity="OC\PlatformBundle\Entity\Taxref")
    * @ORM\JoinColumn(nullable=false)
    */
    private $taxref;

    /**
    * @ORM\ManyToOne(targetEntity="OC\PlatformBundle\Entity\User", inversedBy="observations")
    * @ORM\JoinColumn(nullable=false)
    */
    private $user;

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
     * @param \OC\PlatformBundle\Entity\Picture $picture
     *
     * @return Observation
     */
    public function setPicture(\OC\PlatformBundle\Entity\Picture $picture = null)
    {
        $this->picture = $picture;

        return $this;
    }

    /**
     * Get picture
     *
     * @return \OC\PlatformBundle\Entity\Picture
     */
    public function getPicture()
    {
        return $this->picture;
    }

    /**
     * Set taxref
     *
     * @param \OC\PlatformBundle\Entity\Taxref $taxref
     *
     * @return Observation
     */
    public function setTaxref(\OC\PlatformBundle\Entity\Taxref $taxref)
    {
        $this->taxref = $taxref;

        return $this;
    }

    /**
     * Get taxref
     *
     * @return \OC\PlatformBundle\Entity\Taxref
     */
    public function getTaxref()
    {
        return $this->taxref;
    }

    /**
     * Set user
     *
     * @param \OC\PlatformBundle\Entity\User $user
     *
     * @return Observation
     */
    public function setUser(\OC\PlatformBundle\Entity\User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \OC\PlatformBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }
}
