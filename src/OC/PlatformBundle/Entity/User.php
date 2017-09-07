<?php
// src/PlatformBundle/Entity/User.php

namespace OC\PlatformBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="firstName", type="text", length=255)
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="lastName", type="text", length=255)
     */
    private $lastName;

    /**
    * @ORM\OneToMany(targetEntity="OC\PlatformBundle\Entity\Observation", mappedBy="user")
    */
    private $observations;

    public function __construct()
    {
        parent::__construct();
        
        $this->observations = new ArrayCollection();
        $this->roles[] = 'ROLE_USER';
    }

    /**
     * Set firstName
     *
     * @param string $firstName
     *
     * @return User
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lasttName
     *
     * @param string $lasttName
     *
     * @return User
     */
    public function setLasttName($lasttName)
    {
        $this->lasttName = $lasttName;

        return $this;
    }

    /**
     * Get lasttName
     *
     * @return string
     */
    public function getLasttName()
    {
        return $this->lasttName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     *
     * @return User
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Add observation
     *
     * @param \OC\PlatformBundle\Entity\Observation $observation
     *
     * @return User
     */
    public function addObservation(\OC\PlatformBundle\Entity\Observation $observation)
    {
        $this->observations[] = $observation;

        return $this;
    }

    /**
     * Remove observation
     *
     * @param \OC\PlatformBundle\Entity\Observation $observation
     */
    public function removeObservation(\OC\PlatformBundle\Entity\Observation $observation)
    {
        $this->observations->removeElement($observation);
    }

    /**
     * Get observations
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getObservations()
    {
        return $this->observations;
    }
}
