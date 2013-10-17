<?php

namespace DistSys\ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Attribute
 */
class Attribute
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var \DistSys\ShopBundle\Entity\AttributeType
     */
    private $attributeType;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $products;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->products = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set name
     *
     * @param string $name
     * @return Attribute
     */
    public function setName($name)
    {
        $this->name = $name;
    
        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set attributeType
     *
     * @param \DistSys\ShopBundle\Entity\AttributeType $attributeType
     * @return Attribute
     */
    public function setAttributeType(\DistSys\ShopBundle\Entity\AttributeType $attributeType = null)
    {
        $this->attributeType = $attributeType;
    
        return $this;
    }

    /**
     * Get attributeType
     *
     * @return \DistSys\ShopBundle\Entity\AttributeType 
     */
    public function getAttributeType()
    {
        return $this->attributeType;
    }

    /**
     * Add products
     *
     * @param \DistSys\ShopBundle\Entity\Product $products
     * @return Attribute
     */
    public function addProduct(\DistSys\ShopBundle\Entity\Product $products)
    {
        $this->products[] = $products;
    
        return $this;
    }

    /**
     * Remove products
     *
     * @param \DistSys\ShopBundle\Entity\Product $products
     */
    public function removeProduct(\DistSys\ShopBundle\Entity\Product $products)
    {
        $this->products->removeElement($products);
    }

    /**
     * Get products
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getProducts()
    {
        return $this->products;
    }
}