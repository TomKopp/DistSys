<?php

namespace DistSys\ShopBundle\Controller;
use DistSys\ShopBundle\Entity\Attribute;

use DistSys\ShopBundle\Form\Type\CategorieType;

use Symfony\Component\HttpFoundation\JsonResponse;

use DistSys\ShopBundle\Form\Type\ProfileType;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminController extends Controller {

	public function userAction() {
		$em = $this->getDoctrine()->getManager();
		$users = $em->getRepository('DistSysShopBundle:User')
				->findAllByAktiveUser();

		return $this
				->render('DistSysShopBundle:Admin:user.html.twig',
						array('users' => $users));
	}

	public function userPartAction() {
		$em = $this->getDoctrine()->getManager();
		$users = $em->getRepository('DistSysShopBundle:User')
				->findAllByAktiveUser();

		return $this
				->render('DistSysShopBundle:Admin:userPart.html.twig',
						array('users' => $users));
	}

	public function userShowAction($id) {
		$em = $this->getDoctrine()->getManager();
		$user = $em->getRepository('DistSysShopBundle:User')->findOneById($id);

		return $this
				->render('DistSysShopBundle:Admin:userShow.html.twig',
						array('user' => $user));
	}

	public function userEditAction($id) {
		$em = $this->getDoctrine()->getManager();
		$user = $em->getRepository('DistSysShopBundle:User')->findOneById($id);
		$profileForm = $this->createForm(new ProfileType(), $user);

		return $this
				->render('DistSysShopBundle:Admin:userEdit.html.twig',
						array('user' => $user,
								'profileform' => $profileForm->createView()));
	}

	public function userUpdateAction($id) {

		$em = $this->getDoctrine()->getManager();
		$user = $em->getRepository('DistSysShopBundle:User')->findOneById($id);
		$form = $this->createForm(new ProfileType(), $user);
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
		} else {
			// Zurück mit Fehlerausgabe
			$res = false;
			$status = "Bitte füllen Sie alle benötigten Felder aus.";
		}

		return new JsonResponse(array('res' => $res, 'status' => $status));

	}

	public function userRemoveAction($id) {
		$em = $this->getDoctrine()->getManager();
		$user = $em->getRepository('DistSysShopBundle:User')->findOneById($id);

		$role = $em->getRepository('DistSysShopBundle:Role')
				->findOneByName("ROLE_DELETED");

		$r = $user->getRoles();
		$user->removeRole($r[0]);
		$user->addRole($role);
		$em->persist($user);
		$em->flush();
		$status = true;
		$res = "Benutzer erfolgreich gelöscht!";

		return new JsonResponse(array('res' => $res, 'status' => $status));
	}

	public function categorieAction() {
		$categories = $this->getDoctrine()
				->getRepository('DistSysShopBundle:Attribute')->findAll();
		return $this
				->render('DistSysShopBundle:Admin:categorie.html.twig',
						array('categories' => $categories));
	}
	public function categoriePartAction() {
		$em = $this->getDoctrine()->getManager();
		$categories = $em->getRepository('DistSysShopBundle:Attribute')
				->findAll();

		return $this
				->render('DistSysShopBundle:Admin:categoriePart.html.twig',
						array('categories' => $categories));
	}

	public function categorieShowAction($id) {
		$em = $this->getDoctrine()->getManager();
		$cat = $em->getRepository('DistSysShopBundle:Attribute')
				->findOneById($id);

		return $this
				->render('DistSysShopBundle:Admin:categorieShow.html.twig',
						array('cat' => $cat));
	}

	public function categorieNewAction() {
		$em = $this->getDoctrine()->getManager();
		$catForm = $this->createForm(new CategorieType(), new Attribute());

		return $this
				->render('DistSysShopBundle:Admin:categorieNew.html.twig',
						array('catForm' => $catForm->createView()));
	}

	public function categorieSaveAction() {

		$em = $this->getDoctrine()->getManager();
		$form = $this->createForm(new CategorieType(), new Attribute());
		$form->bind($this->getRequest());

		// Speichern, wenn das Formular Valid ist
		if ($form->isValid()) {
			$cat = $form->getData();

			// Adresse in die Datenbank speichern
			$em->persist($cat);
			$em->flush();

			// Weiterleitung zur Übersicht
			$res = true;
			$status = "Erfolgreich angelegt.";
		} else {
			// Zurück mit Fehlerausgabe
			$res = false;
			$status = "Bitte füllen Sie alle benötigten Felder aus.";
		}

		return new JsonResponse(array('res' => $res, 'status' => $status));

	}
	
	public function categorieRemoveAction($id) {
		$em = $this->getDoctrine()->getManager();
		$cat = $em->getRepository('DistSysShopBundle:Attribute')->findOneById($id);
	

		$em->remove($cat);
		$em->flush();
		$status = true;
		$res = "Kategorie erfolgreich gelöscht!";
	
		return new JsonResponse(array('res' => $res, 'status' => $status));
	}

}
