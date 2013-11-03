<?php

namespace DistSys\ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BookingItem
 */
class BookingItem
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $quatity;

    /**
     * @var \DistSys\ShopBundle\Entity\Booking
     */
    private $booking;

    /**
     * @var \DistSys\ShopBundle\Entity\Product
     */
    private $product;


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
     * Set quatity
     *
     * @param integer $quatity
     * @return BookingItem
     */
    public function setQuatity($quatity)
    {
        $this->quatity = $quatity;
    
        return $this;
    }

    /**
     * Get quatity
     *
     * @return integer 
     */
    public function getQuatity()
    {
        return $this->quatity;
    }

    /**
     * Set booking
     *
     * @param \DistSys\ShopBundle\Entity\Booking $booking
     * @return BookingItem
     */
    public function setBooking(\DistSys\ShopBundle\Entity\Booking $booking = null)
    {
        $this->booking = $booking;
    
        return $this;
    }

    /**
     * Get booking
     *
     * @return \DistSys\ShopBundle\Entity\Booking 
     */
    public function getBooking()
    {
        return $this->booking;
    }

    /**
     * Set product
     *
     * @param \DistSys\ShopBundle\Entity\Product $product
     * @return BookingItem
     */
    public function setProduct(\DistSys\ShopBundle\Entity\Product $product = null)
    {
        $this->product = $product;
    
        return $this;
    }

    /**
     * Get product
     *
     * @return \DistSys\ShopBundle\Entity\Product 
     */
    public function getProduct()
    {
        return $this->product;
    }
}