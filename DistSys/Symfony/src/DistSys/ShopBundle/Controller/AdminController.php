<?php

namespace DistSys\ShopBundle\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

use DistSys\ShopBundle\Form\Type\ProfileType;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminController extends Controller {

	public function attributeAction() {
		$categories = $this->getDoctrine()
				->getRepository('DistSysShopBundle:Attribute')->findAll();
		return $this->render(array('categories' => $categories));
	}

	public function userAction() {
		$em = $this->getDoctrine()->getManager();
		$users = $em->getRepository('DistSysShopBundle:User')->findAllByAktiveUser();
		
		

		return $this->render('DistSysShopBundle:Admin:user.html.twig', array('users' => $users));
	}

	public function userShowAction($id) {
		$em = $this->getDoctrine()->getManager();
		$user = $em->getRepository('DistSysShopBundle:User')->findOneById($id);

		$profileForm = $this->createForm(new ProfileType(), $user);

		return $this->render('DistSysShopBundle:Admin:userShow.html.twig', array('user' => $user, 'form' => $profileForm->createView()));
	}

	public function userEditAction($id) {
		$em = $this->getDoctrine()->getManager();
		$user = $em->getRepository('DistSysShopBundle:User')->findOneById($id);
    $profileForm = $this->createForm(new ProfileType(), $user);

		return $this->render('DistSysShopBundle:Admin:userEdit.html.twig', array('user' => $user, 'profileform' => $profileForm->createView()));
	}

	public function userUpdateAction($id) {

		$em = $this->getDoctrine()->getManager();
		$user = $em->getRepository('DistSysShopBundle:User')->findOneById($id);
		$form = $this->createForm( new ProfileType(), $user );
		$form->bind($this->getRequest());
	
    // Speichern, wenn das Formular Valid ist
    if ($form->isValid()) {
         $user = $form->getData();


                
         // Adresse in die Datenbank speichern
         $em->persist($user);
         $em->flush();
                        
         // Weiterleitung zur Übersicht 
         $res = true;
         $status = "Benutzerdaten erfolgreich geändert.";
      }else {
      	// Zurück mit Fehlerausgabe
      	$res = false;
        $status = "Bitte füllen Sie alle benötigten Felder aus.";
      }
	
		return new JsonResponse(array('res' => $res, 'status' => $status));

	}

	public function userRemoveAction($id) {
		$em = $this->getDoctrine()->getManager();
		$user = $em->getRepository('DistSysShopBundle:User')->findOneById($id);

		$role = $em->getRepository('DistSysShopBundle:Role')->findOneByName("ROLE_DELETED");
   
		$r = $user->getRoles();
		$user->removeRole($r[0]);
		$user->addRole($role);
		$em->persist($user);
		$em->flush();
		$status = true;
		$res = "Benutzer erfolgreich gelöscht!";

		return new JsonResponse(array('res' => $res, 'status' => $status));
	}

}
