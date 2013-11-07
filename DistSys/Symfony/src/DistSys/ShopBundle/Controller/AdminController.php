<?php

namespace DistSys\ShopBundle\Controller;
use DistSys\ShopBundle\Form\Type\ProductType;

use DistSys\ShopBundle\Entity\Product;

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
			$attrType = $this->getDoctrine()->getRepository('DistSysShopBundle:AttributeType')->findOneByName('category');
			
			$cat->setAttributeType($attrType);

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

	public function categorieEditAction($id) {
		$em = $this->getDoctrine()->getManager();
		$cat = $em->getRepository('DistSysShopBundle:Attribute')->findOneById($id);
		$catForm = $this->createForm(new CategorieType(), $cat);

		return $this
				->render('DistSysShopBundle:Admin:categorieEdit.html.twig',
						array('cat' => $cat,
								'catform' => $catForm->createView()));
	}
	
	public function categorieUpdateAction($id) {
	
		$em = $this->getDoctrine()->getManager();
		$cat = $em->getRepository('DistSysShopBundle:Attribute')->findOneById($id);
		$form = $this->createForm(new CategorieType(), $cat);
		$form->bind($this->getRequest());
	
		// Speichern, wenn das Formular Valid ist
		if ($form->isValid()) {
			$user = $form->getData();
	
			// Adresse in die Datenbank speichern
			$em->persist($cat);
			$em->flush();
	
			// Weiterleitung zur Übersicht
			$res = true;
			$status = "Kategorie erfolgreich geändert.";
		} else {
			// Zurück mit Fehlerausgabe
			$res = false;
			$status = "Bitte füllen Sie alle benötigten Felder aus.";
		}
	
		return new JsonResponse(array('res' => $res, 'status' => $status));
	
	}
	
	public function productAction() {
		$em = $this->getDoctrine()->getManager();
		$products = $em->getRepository('DistSysShopBundle:Product')->findAll();
	
		return $this
		->render('DistSysShopBundle:Admin:product.html.twig',
				array('products' => $products));
	}

	public function productPartAction() {
		$em = $this->getDoctrine()->getManager();
		$products = $em->getRepository('DistSysShopBundle:Product')
		->findAll();
	
		return $this
		->render('DistSysShopBundle:Admin:productPart.html.twig',
				array('products' => $products));
	}
	
	public function productNewAction() {
		$em = $this->getDoctrine()->getManager();
		$prodForm = $this->createForm(new ProductType(), new Product());
	
		return $this
		->render('DistSysShopBundle:Admin:productNew.html.twig',
				array('prodForm' => $prodForm->createView()));
	}
	

	
	
	public function productSaveAction() {
	
		$em = $this->getDoctrine()->getManager();
		$form = $this->createForm(new ProductType(), new Product());
		$form->bind($this->getRequest());
	
		// Speichern, wenn das Formular Valid ist
		if ($form->isValid()) {
			$prod = $form->getData();
      // TODO
	
			// Adresse in die Datenbank speichern
			$em->persist($prod);
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
	
	public function productRemoveAction($id) {
		$em = $this->getDoctrine()->getManager();
		$prod = $em->getRepository('DistSysShopBundle:Product')->findOneById($id);
	
	
		$em->remove($prod);
		$em->flush();
		$status = true;
		$res = "Produkt erfolgreich gelöscht!";
	
		return new JsonResponse(array('res' => $res, 'status' => $status));
	}
	

	public function productShowAction($id) {
		$em = $this->getDoctrine()->getManager();
		$prod = $em->getRepository('DistSysShopBundle:Product')
		->findOneById($id);
	
		return $this
		->render('DistSysShopBundle:Admin:productShow.html.twig',
				array('prod' => $prod));
	}
	
	public function productEditAction($id) {
		$em = $this->getDoctrine()->getManager();
		$prod = $em->getRepository('DistSysShopBundle:Product')->findOneById($id);
		$prodForm = $this->createForm(new ProductType(), $prod);
	
		return $this
		->render('DistSysShopBundle:Admin:productEdit.html.twig',
				array('prod' => $prod,
						'prodForm' => $prodForm->createView()));
	}
	
	public function productUpdateAction($id) {
	
		$em = $this->getDoctrine()->getManager();
		$prod = $em->getRepository('DistSysShopBundle:Product')->findOneById($id);
		$form = $this->createForm(new ProductType(), $prod);
		$form->bind($this->getRequest());
	
		// Speichern, wenn das Formular Valid ist
		if ($form->isValid()) {
			$user = $form->getData();
	
			// Adresse in die Datenbank speichern
			$em->persist($prod);
			$em->flush();
	
			// Weiterleitung zur Übersicht
			$res = true;
			$status = "Produkt erfolgreich geändert.";
		} else {
			// Zurück mit Fehlerausgabe
			$res = false;
			$status = "Bitte füllen Sie alle benötigten Felder aus.";
		}
	
		return new JsonResponse(array('res' => $res, 'status' => $status));
	
	}

}
