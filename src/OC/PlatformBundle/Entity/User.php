<?php
// src/PlatformBundle/Entity/User.php

namespace OC\PlatformBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

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
     * @ORM\Column(name="lasttName", type="text", length=255)
     */
    private $lasttName;

    public function __construct()
    {
        parent::__construct();
        
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
}
