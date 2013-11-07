<?php

namespace DistSys\ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * GalleryItem
 */
class GalleryItem {

  /**
   * @var integer
   */
  private $id;

  /**
   * @var string
   */
  private $imgUrl;

  /**
   * @var string
   */
  private $imgAlt;

  /**
   * @var string
   */
  private $imgTitle;

  /**
   * @var Assert
   */
  private $file;
  


  /**
   * Get id
   *
   * @return integer 
   */
  public function getId() {
    return $this->id;
  }

  /**
   * Set imgUrl
   *
   * @param string $imgUrl
   * @return GalleryItem
   */
  public function setImgUrl($imgUrl) {
    $this->imgUrl = $imgUrl;

    return $this;
  }

  /**
   * Get imgUrl
   *
   * @return string 
   */
  public function getImgUrl() {
    return $this->imgUrl;
  }

  /**
   * Set imgAlt
   *
   * @param string $imgAlt
   * @return GalleryItem
   */
  public function setImgAlt($imgAlt) {
    $this->imgAlt = $imgAlt;

    return $this;
  }

  /**
   * Get imgAlt
   *
   * @return string 
   */
  public function getImgAlt() {
    return $this->imgAlt;
  }

  /**
   * Set imgTitle
   *
   * @param string $imgTitle
   * @return GalleryItem
   */
  public function setImgTitle($imgTitle) {
    $this->imgTitle = $imgTitle;

    return $this;
  }

  /**
   * Get imgTitle
   *
   * @return string 
   */
  public function getImgTitle() {
    return $this->imgTitle;
  }

/**
     * Sets file.
     *
     * @param UploadedFile $file
     */
    public function setFile(UploadedFile $file = null)
    {
            $this->file = $file;
    }
    
    /**
     * Get file.
     *
     * @return UploadedFile
     */
    public function getFile()
    {
            return $this->file;
    }

    public function getAbsolutePath()
    {
        return null === $this->imgUrl
            ? null
            : $this->getUploadRootDir().'/'.$this->imgUrl;
    }

    public function getWebPath()
    {
        return null === $this->imgUrl
            ? null
            : $this->getUploadDir().'/'.$this->imgUrl;
    }

    protected function getUploadRootDir()
    {
        // the absolute directory path where uploaded
        // documents should be saved
        return __DIR__.'/../../../../../web/'.$this->getUploadDir();
    }

    protected function getUploadDir()
    {
        // get rid of the __DIR__ so it doesn't screw up
        // when displaying uploaded doc/image in the view.
        return 'uploads/documents';
    }
    
    public function upload()
    {
            // the file property can be empty if the field is not required
            if (null === $this->getFile()) {
            	echo "error";
                    return;
            }
    
            // use the original file name here but you should
            // sanitize it at least to avoid any security issues
    
            // move takes the target directory and then the
            // target filename to move to
            $this->getFile()->move(
                            $this->getUploadRootDir(),
                            $this->getFile()->getClientOriginalName()
            );
    
            // set the path property to the filename where you've saved the file
            $this->imgUrl = $this->getFile()->getClientOriginalName();
    
            // clean up the file property as you won't need it anymore
            $this->file = null;
    }

    /**
     * Constructor
     */
    public function __construct() {
    	$this->product = new \Doctrine\Common\Collections\ArrayCollection();
    }
    /**
     * @var \DistSys\ShopBundle\Entity\Product
     */
    private $product;


    /**
     * Set product
     *
     * @param \DistSys\ShopBundle\Entity\Product $product
     * @return GalleryItem
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