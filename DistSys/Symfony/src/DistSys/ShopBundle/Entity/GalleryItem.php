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
   * Constructor
   */
  public function __construct() {
  	$this->product = new \Doctrine\Common\Collections\ArrayCollection();
  }

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
   * Set file
   * 
   * @param \Symfony\Component\HttpFoundation\File\UploadedFile $file
   */
  public function setFile(UploadedFile $file = NULL) {
    $this->file = $file;
    // check if we have an old image path
    if (!empty($this->imgUrl)) {
    // store the old name to delete after the update
      $this->temp = $this->imgUrl;
      $this->imgUrl = null;
    } else {
      $this->imgUrl = 'initial';
    }
  }

  /**
   * 
   * @return UploadedFile
   */
  public function getFile() {
    return $this->file;
  }

  /**
   * PrePersist
   */
  public function preUpload() {
    if (NULL !== $this->getFile()) {
    // do whatever you want to generate a unique name
      $fileNameOrig = $this->file->getClientOriginalName();
      $ext = explode('.', $fileNameOrig);
      if (!in_array(end($ext), array('jpg', 'jpeg', 'gif', 'png'))) {
        return; // @ToDo error handling throw exeption
      }
      $fileName = \preg_replace('#[^\\pL\d]+#u', '-', $ext[0]);
      $rnd = uniqid(mt_rand());
      $this->imgUrl = $fileName . $rnd . '.' . $this->file->guessExtension();
    }
  }

  /**
   * Get absolute Path to image
   * 
   * @return string|NULL
   */
  public function getAbsolutePath() {
    return null === $this->imgUrl ? null : $this->getUploadRootDir() . '/' . $this->imgUrl;
  }

  /**
   * Get Path to image from 'web'-folder
   * 
   * @return string|NULL
   */
  public function getWebPath() {
    return null === $this->imgUrl ? null : $this->getUploadDir() . '/' . $this->imgUrl;
  }

  /**
   * Get uploadRootDir
   * 
   * @return string
   */
  protected function getUploadRootDir() {
    // the absolute directory path where uploaded
    // documents should be saved
    return __DIR__ . '/../../../../web/' . $this->getUploadDir();
    // ->/Entity/ShopBundle/schmucklis/src->/web
  }

  /**
   * Get uploadDir
   * 
   * @param string $productName
   * @return string
   */
  protected function getUploadDir() {
    // get rid of the __DIR__ so it doesn't screw up
    // when displaying uploaded doc/image in the view.
    return 'images/products/';
  }

  /**
   * Post Persist
   */
  public function uploadFile() {
    if (NULL === $this->file) {
      return; // @ToDo error handling
    }

    // if there is an error when moving the file, an exception will
    // be automatically thrown by move(). This will properly prevent
    // the entity from being persisted to the database on error
    $this->file->move($this->getUploadRootDir(), $this->imgUrl);

    // check if we have an old image
    if (isset($this->temp)) {
      // delete the old image
      unlink($this->getUploadRootDir() . '/' . $this->temp);
      // clear the temp image path
      $this->temp = null;
    }
    // clean up the file property as you won't need it anymore
    $this->file = NULL;
  }

  /**
   * Post Remove
   */
  public function removeUpload() {
    if ($file = $this->getAbsolutePath()) { //yes this is correct
      unlink($file);
    }
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