<?php

namespace DistSys\ShopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class NavigationController extends Controller {

  public function indexAction() {
    $category = $this->getDoctrine()->getRepository('DistSysShopBundle:AttributeType')->findByName('category');
    $categories = $category->getAttributes();

    return $this->render('DistSysShopBundle:Menu:navigation.html.twig', array('categories' => $categories));
  }

}