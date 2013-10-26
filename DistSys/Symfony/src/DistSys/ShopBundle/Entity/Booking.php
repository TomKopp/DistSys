<?php

namespace DistSys\ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Booking
 */
class Booking
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var \DateTime
     */
    private $dateOfOrder;

    /**
     * @var string
     */
    private $status = '';

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $bookingItems;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->bookingItems = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set dateOfOrder
     *
     * @param \DateTime $dateOfOrder
     * @return Booking
     */
    public function setDateOfOrder($dateOfOrder)
    {
        $this->dateOfOrder = $dateOfOrder;
    
        return $this;
    }

    /**
     * Get dateOfOrder
     *
     * @return \DateTime 
     */
    public function getDateOfOrder()
    {
        return $this->dateOfOrder;
    }

    /**
     * Set status
     *
     * @param string $status
     * @return Booking
     */
    public function setStatus($status)
    {
        $this->status = $status;
    
        return $this;
    }

    /**
     * Get status
     *
     * @return string 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Add bookingItems
     *
     * @param \DistSys\ShopBundle\Entity\BookingItem $bookingItems
     * @return Booking
     */
    public function addBookingItem(\DistSys\ShopBundle\Entity\BookingItem $bookingItems)
    {
        $this->bookingItems[] = $bookingItems;
    
        return $this;
    }

    /**
     * Remove bookingItems
     *
     * @param \DistSys\ShopBundle\Entity\BookingItem $bookingItems
     */
    public function removeBookingItem(\DistSys\ShopBundle\Entity\BookingItem $bookingItems)
    {
        $this->bookingItems->removeElement($bookingItems);
    }

    /**
     * Get bookingItems
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getBookingItems()
    {
        return $this->bookingItems;
    }
}