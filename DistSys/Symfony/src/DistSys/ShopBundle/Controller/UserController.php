<?php

namespace DistSys\ShopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use schmucklis\ShopBundle\Entity\Wishlist;
use schmucklis\ShopBundle\Entity\WishlistItem;

class UserController extends Controller {
  #basic function to show user data
  public function showAction($userId) {
    $repository = $this->getDoctrine()->getRepository('schmucklisShopBundle:User');
    $user = $repository->find($userId);

    if (!$user) {
      throw $this->createNotFoundException('No product found for username ' . $userId);
    } else {
      return $this->render(
          'schmucklisShopBundle:User:userShow.html.twig', array('user' => $user)
      );
    }
  }

  #greeting screen for User
  public function myAccountAction() {
    $username = $this->get('security.context')->getToken()->getUser();
    $user = $this->getDoctrine()->getRepository('schmucklisShopBundle:User')->findOneByEmail($username);

    return $this->render(
        'schmucklisShopBundle:User:myAccount.html.twig', array(
        'userdata' => $user
        )
    );
  }

  #form to change Userdata
  public function myDataAction() {
    $em = $this->getDoctrine()->getManager();
    $request = $this->getRequest();

    $username = $this->get('security.context')->getToken()->getUser();
    $user = $em->getRepository('schmucklisShopBundle:User')->findOneByEmail($username);
    $lastUrl = $request->headers->get('referer');

    #get inserted data from Form          
    #check weather there are changes
    #alter the user entry in the database
    if ($request->get('_gender') && $request->get('_gender') !== $user->getGender())
      $user->setGender($request->get('_gender'));
    if ($request->get('_firstname') && $request->get('_firstname') !== $user->getFirstname())
      $user->setFirstname($request->get('_firstname'));
    if ($request->get('_lastname') && $request->get('_lastname') !== $user->getLastname())
      $user->setLastname($request->get('_lastname'));
    if ($request->get('_street') && $request->get('_street') !== $user->getStreet())
      $user->setStreet($request->get('_street'));
    if ($request->get('_postal') && $request->get('_postal') !== $user->getPostal())
      $user->setPostal($request->get('_postal'));
    if ($request->get('_city') && $request->get('_city') !== $user->getCity())
      $user->setCity($request->get('_city'));
    $em->flush();

    return $this->render(
        'schmucklisShopBundle:User:myData.html.twig', array(
        'user' => $user,
        'back' => $lastUrl,
        )
    );
  }

  #show Orders
  public function myOrdersAction() {
    $username = $this->get('security.context')->getToken()->getUser();
    $user = $this->getDoctrine()->getRepository('schmucklisShopBundle:User')->findOneByEmail($username);
    $orders = $this->getDoctrine()->getRepository('schmucklisShopBundle:Booking')->findByUser($user->getUserId());
    $orderArray = array();
    #write orders in an array, necessary because of the DateTimeObject
    for ($i = 0; $i < count($orders); $i++) {
      $orderdate = $orders[$i]->getDateOfOrder();
      $orderdate->format('Y-m-d H:i:s');
      $orderArray[$i]['orderdate'] = $orderdate;
      $orderArray[$i]['id'] = $orders[$i]->getId();
      $priceComplete = 0;

      switch ($orders[$i]->getStatus()) {
        case 1:
          $orderArray[$i]['status'] = 'eingegangen';
          break;
        case 2:
          $orderArray[$i]['status'] = 'in Bearbeitung';
          break;
        case 3:
          $orderArray[$i]['status'] = 'versendet';
          break;
        case 4:
          $orderArray[$i]['status'] = 'abgeschlossen';
          break;
        case 5:
          $orderArray[$i]['status'] = 'storniert';
          break;
        default:
          $orderArray[$i]['status'] = 'undefiniert';
      }
      #get OrderItems
      $orderArray[$i]['items'] = $this->getDoctrine()->getRepository('schmucklisShopBundle:BookingItem')->findById($orders[$i]->getId());
      $k = 0;
      foreach ($orderArray[$i]['items'] as $item) {
        $bookedProduct = $this->getDoctrine()->getRepository('schmucklisShopBundle:Product')->find($item->getProduct());
        $orderArray[$i]['booked'][$k] = $bookedProduct;
        $k++;
        $priceComplete+=$item->getQuantity() * $bookedProduct->getPrice();
      }
      if ($priceComplete < 50) {
        $priceComplete+=1.45;
      }
      $orderArray[$i]['priceComplete'] = $priceComplete;
    }
    return $this->render(
        'schmucklisShopBundle:User:myOrders.html.twig', array(
        'orderArray' => $orderArray,
        )
    );
  }

  #function to delete Useraccount
  public function deleteAccountAction($userId) {
    $em = $this->getDoctrine()->getManager();
    $request = $this->getRequest();
    $username = $this->get('security.context')->getToken()->getUser();
    $user = $this->getDoctrine()->getRepository('schmucklisShopBundle:User')->findOneByEmail($username);
    $error = false;
    #check password
    if ($request->get('password') != '') {
      if ($user->getPassword() === md5($request->get('password'))) {  #delete user object
        $em->remove($user);
        $em->flush();
        $user = 0;
        #redirect to homepage
        return $this->redirect($this->generateUrl('schmucklisLogout'));
      } else {
        $error = true;
      }
    }
    #password does not match: redirect
    return $this->render(
        'schmucklisShopBundle:User:deleteAccount.html.twig', array(
        'user' => $user,
        'error' => $error,
        )
    );
  }

}
