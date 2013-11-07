<?php

namespace DistSys\ShopBundle\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CartController extends Controller {

  public function indexAction() {
    // function to show the current ShoppingCart
    $repository = $this->getDoctrine()->getRepository('DistSysShopBundle:Product');
    $session = $this->getRequest()->getSession();
    $lastUrl = $this->getRequest()->headers->get('referer');
    $cartContent = $session->get('cartContent');
    $totalPrice = 0;
    $resultComplete = array();

    for ($i = 1; $i <= count($cartContent); $i++) {
      $result = $repository->find($cartContent[$i]['id']);
      $totalPrice += $result->getPrice() * $cartContent[$i]['amount'];

      $resultComplete[$i]['id'] = $cartContent[$i]['id'];
      $resultComplete[$i]['amount'] = $cartContent[$i]['amount'];
      $resultComplete[$i]['name'] = $result->getName();
      $resultComplete[$i]['price'] = $result->getPrice();
      $resultComplete[$i]['stock'] = $result->getStock();
    }
    unset($result);

    return $this->render(
        'DistSysShopBundle:Shop:cart.html.twig', array(
        'cartContent' => $resultComplete,
        'priceComplete' => $totalPrice,
        'lastUrl' => $lastUrl,
        )
    );
  }

  public function addAction($productId) {
    // function to add a product to the currend ShoppingCart
    $session = $this->getRequest()->getSession();
    //$session->getFlashBag()->add('cartAdd', 'Produkt Nr.' . $productId . ' wurde Ihrem Warenkorb hinzugefügt.');

    if (!$session->has('cartContent')) {
      $cartContent = array();
    } else {
      $cartContent = $session->get('cartContent');
    }

    if (!$session->has('cartAmount')) {
      $cartAmount = 0;
      $priceComplete = 0;
    } else {
      $cartAmount = $session->get('cartAmount');
      $priceComplete = $session->get('priceComplete');
    }
    $priceComplete += $this->getDoctrine()->getRepository('DistSysShopBundle:Product')->find($productId)->getPrice();

    $added = false;
    
    #check if product already is in the cart; if so, count the amount up by one
    for ($k = 1; $k <= count($cartContent); $k++) {
      if ($cartContent[$k]['id'] === $productId) {
        $cartContent[$k]['amount'] ++;
        $added = true;
        break;
      }
      
    }

    #add new product to Cart
    if ($added === false) {
      $cartContent[$k]['id'] = $productId;
      $cartContent[$k]['amount'] = 1;
      $cartAmount++;
    }
    #sessionVar for cartContent_anz
    #sessionVar for priceComplete
    $session->set('cartContent', $cartContent);
    $session->set('cartAmount', $cartAmount);
    $session->set('priceComplete', $priceComplete);
    
    $count = 0;
    for ($u = 1; $u <= count($cartContent); $u++) {
    	$count += 	$cartContent[$u]['amount'];
    
    
    }
    
    $session->set('count', $count);

    #redirect to the shopping cart  $res = false;
			$status = "Warenkorb erfolgreich befüllt.";
		  $res = true;
	
		return new JsonResponse(array('res' => $res, 'status' => $status, 'count' => $count));
  }

  //function to remove an item from the Cart
  public function removeAction($productId) {
    #return $this->redirect($request->headers->get('referer'));
    $session = $this->getRequest()->getSession();
    #get cartContent from session
    $cartContent = $session->get('cartContent');
    $anz = count($cartContent);
    $removeAnz = 0;

    for ($i = 1; $i <= $anz; $i++) {
      if ($cartContent[$i]['id'] === $productId) {
        $removeAnz = $cartContent[$i]['amount'];
        break;
      }
    }

    #pass every element after the deletet position one position foreward
    for ($i; $i < $anz; $i++) {
      $cartContent[$i]['id'] = $cartContent[$i + 1]['id'];
      $cartContent[$i]['amount'] = $cartContent[$i + 1]['amount'];
    }
    #delete last element
    unset($cartContent[$anz]);

    #set cartContent into the session
    $session->set('cartContent', $cartContent);
    $session->getFlashBag()->add('cartRemove', 'Produkt Nr.' . $productId . ' wurde aus Ihrem Warenkorb entfernt.');

    #update session data for template
    $cartAmount = $session->get('cartAmount');
    $priceComplete = $session->get('priceComplete');

    $cartAmount--;
    $priceComplete -= $this->getDoctrine()->getRepository('DistSysShopBundle:Product')->find($productId)->getPrice() * $removeAnz;

    $session->set('cartAmount', $cartAmount);
    $session->set('priceComplete', $priceComplete);

    #redirect to the shopping cart
    return $this->redirect($this->generateUrl('my_cart'));
  }

  #function if the amount of an item in the Cart is changed 

  public function changeAction($productId) {
    $request = $this->getRequest();
    $session = $request->getSession();
    $result = $this->getDoctrine()->getRepository('DistSysShopBundle:Product')->find($productId);
    $cartContent = $session->get('cartContent');
    $priceComplete = $session->get('priceComplete');

    for ($i = 1; $i <= count($cartContent); $i++) {
      if ($cartContent[$i]['id'] == $productId) {
        $priceComplete -= ($cartContent[$i]['amount'] * $result->getPrice());
        $cartContent[$i]['amount'] = $request->get('prod_anz');
        $priceComplete += ($cartContent[$i]['amount'] * $result->getPrice());
        break;
      }
    }

    $session->set('cartContent', $cartContent);
    $session->set('priceComplete', $priceComplete);
    #redirect to the shopping cart
    
    $count = 0;
    for ($u = 1; $u <= count($cartContent); $u++) {
    	$count += 	$cartContent[$u]['amount'];
    
    
    }
    
    $session->set('count', $count);
    
    return $this->redirect($this->generateUrl('my_cart'));
  }

}
