<?php

namespace DistSys\ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SimpleSite
 */
class SimpleSite
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $content = '';


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
     * Set content
     *
     * @param string $content
     * @return SimpleSite
     */
    public function setContent($content)
    {
        $this->content = $content;
    
        return $this;
    }

    /**
     * Get content
     *
     * @return string 
     */
    public function getContent()
    {
        return $this->content;
    }
}