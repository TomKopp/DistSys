<?php

namespace DistSys\ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * User
 */
class User
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $email = '';

    /**
     * @var string
     */
    private $firstname = '';

    /**
     * @var string
     */
    private $lastname = '';

    /**
     * @var boolean
     */
    private $male;

    /**
     * @var string
     */
    private $street = '';

    /**
     * @var string
     */
    private $postal = '';

    /**
     * @var string
     */
    private $city = '';

    /**
     * @var string
     */
    private $phone = '';

    /**
     * @var string
     */
    private $passwd = '';

    /**
     * @var boolean
     */
    private $status;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $bookings;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->bookings = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
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
     * Set email
     *
     * @param string $email
     * @return User
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
     * Set firstname
     *
     * @param string $firstname
     * @return User
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
    
        return $this;
    }

    /**
     * Get firstname
     *
     * @return string 
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set lastname
     *
     * @param string $lastname
     * @return User
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
    
        return $this;
    }

    /**
     * Get lastname
     *
     * @return string 
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set male
     *
     * @param boolean $male
     * @return User
     */
    public function setMale($male)
    {
        $this->male = $male;
    
        return $this;
    }

    /**
     * Get male
     *
     * @return boolean 
     */
    public function getMale()
    {
        return $this->male;
    }

    /**
     * Set street
     *
     * @param string $street
     * @return User
     */
    public function setStreet($street)
    {
        $this->street = $street;
    
        return $this;
    }

    /**
     * Get street
     *
     * @return string 
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * Set postal
     *
     * @param string $postal
     * @return User
     */
    public function setPostal($postal)
    {
        $this->postal = $postal;
    
        return $this;
    }

    /**
     * Get postal
     *
     * @return string 
     */
    public function getPostal()
    {
        return $this->postal;
    }

    /**
     * Set city
     *
     * @param string $city
     * @return User
     */
    public function setCity($city)
    {
        $this->city = $city;
    
        return $this;
    }

    /**
     * Get city
     *
     * @return string 
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set phone
     *
     * @param string $phone
     * @return User
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
     * Set passwd
     *
     * @param string $passwd
     * @return User
     */
    public function setPasswd($passwd)
    {
        $this->passwd = $passwd;
    
        return $this;
    }

    /**
     * Get passwd
     *
     * @return string 
     */
    public function getPasswd()
    {
        return $this->passwd;
    }

    /**
     * Set status
     *
     * @param boolean $status
     * @return User
     */
    public function setStatus($status)
    {
        $this->status = $status;
    
        return $this;
    }

    /**
     * Get status
     *
     * @return boolean 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Add bookings
     *
     * @param \DistSys\ShopBundle\Entity\Booking $bookings
     * @return User
     */
    public function addBooking(\DistSys\ShopBundle\Entity\Booking $bookings)
    {
        $this->bookings[] = $bookings;
    
        return $this;
    }

    /**
     * Remove bookings
     *
     * @param \DistSys\ShopBundle\Entity\Booking $bookings
     */
    public function removeBooking(\DistSys\ShopBundle\Entity\Booking $bookings)
    {
        $this->bookings->removeElement($bookings);
    }

    /**
     * Get bookings
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getBookings()
    {
        return $this->bookings;
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $roles;


    /**
     * Add roles
     *
     * @param \DistSys\ShopBundle\Entity\Role $roles
     * @return User
     */
    public function addRole(\DistSys\ShopBundle\Entity\Role $roles)
    {
        $this->roles[] = $roles;
    
        return $this;
    }

    /**
     * Remove roles
     *
     * @param \DistSys\ShopBundle\Entity\Role $roles
     */
    public function removeRole(\DistSys\ShopBundle\Entity\Role $roles)
    {
        $this->roles->removeElement($roles);
    }

    /**
     * Get roles
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRoles()
    {
        return $this->roles;
    }
}