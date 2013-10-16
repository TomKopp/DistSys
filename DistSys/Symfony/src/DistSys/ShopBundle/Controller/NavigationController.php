<?php

namespace DistSys\ShopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class NavigationController extends Controller {

  public function indexAction() {

    $categories=  $this->getDoctrine()->getRepository('DistSysShopBundle:Attribute')->findByAttrType;

    return $this->render('DistSysShopBundle:Menu:navigation.html.twig', array('categories' => $categories));
  }

}