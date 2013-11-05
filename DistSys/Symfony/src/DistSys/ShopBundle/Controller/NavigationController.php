<?php

namespace DistSys\ShopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class NavigationController extends Controller {

  public function indexAction() {
    $category = $this->getDoctrine()->getRepository('DistSysShopBundle:AttributeType')->findOneByName('category');
    if ($category) {
      $categories = $this->getDoctrine()->getRepository('DistSysShopBundle:Attribute')->findByAttributeType($category->getId());
    } else {
      $categories = array();
    }

    return $this->render('DistSysShopBundle:Default:navigation.html.twig', array('categories' => $categories));
  }

}
