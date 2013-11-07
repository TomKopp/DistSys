<?php 
namespace DistSys\ShopBundle\Form\Model;


use Symfony\Component\Validator\Constraints as Assert;

use DistSys\ShopBundle\Entity\Product;


class ProductForm
{

    
    /**
     * @Assert\Type(type="DistSys\ShopBundle\Entity\Product")
     */
    protected $product;
    


    
    public function setProduct(Product $product)
    {
            $this->product = $product;
    }
    
    public function getProduct()
    {
            return $this->product;
    }

    
    



}