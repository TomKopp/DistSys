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
     * @var \DistSys\ShopBundle\Entity\AttrType
     */
    private $attributeType;


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
     * @param \DistSys\ShopBundle\Entity\AttrType $attributeType
     * @return Attribute
     */
    public function setAttributeType(\DistSys\ShopBundle\Entity\AttrType $attributeType = null)
    {
        $this->attributeType = $attributeType;
    
        return $this;
    }

    /**
     * Get attributeType
     *
     * @return \DistSys\ShopBundle\Entity\AttrType 
     */
    public function getAttributeType()
    {
        return $this->attributeType;
    }
}