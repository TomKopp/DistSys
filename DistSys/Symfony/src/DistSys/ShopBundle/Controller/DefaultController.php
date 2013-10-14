<?php

namespace DistSys\ShopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($url)
    {
        return $this->render('DistSysShopBundle:Default:index.html.twig', array('name' => $url));
    }
}
