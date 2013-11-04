<?php

namespace DistSys\ShopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class NavigationController extends Controller {

  public function indexAction() {
    $category = $this->getDoctrine()->getRepository('DistSysShopBundle:AttributeType')->findOneByName('category');
    $categories = $this->getDoctrine()->getRepository('DistSysShopBundle:Attribute')->findByAttributeType($category->getId());
    /*if (is_a($category, 'AttributeType')) {
      $categories = $category->getAttributes();
//      $categories = $this->getDoctrine()->getRepository('DistSysShopBundle:Attribute')->findByAttributeType($category->getId());
      var_dump('category = AttributeType');
    } else {
      $categories = array();
      var_dump('category != AttributeType');
    }
*/
    //$categories = $this->getDoctrine()->getRepository('DistSysShopBundle:Attribute')->findByAttributeType(1);

    return $this->render('DistSysShopBundle:Default:navigation.html.twig', array('categories' => $categories));
  }

}
