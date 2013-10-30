<?php

namespace DistSys\ShopBundle\Controller;


use DistSys\ShopBundle\Form\Model\Registration;
use DistSys\ShopBundle\Form\Type\RegistrationType;
use DistSys\ShopBundle\Repository;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Security\Core\SecurityContext;


class SecurityController extends Controller
{
	/**
	 * @Template()
	 */
    public function loginAction()
    {
		// Session laden
    	
    	$request = $this->getRequest();
    	$session = $request->getSession();
    	
    	// get the login error if there is one
    	if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
    		$error = $request->attributes->get(
    		  SecurityContext::AUTHENTICATION_ERROR
    		);
    	} else {
    		$error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
    		$session->remove(SecurityContext::AUTHENTICATION_ERROR);
    	}
    	
    	return 
    			array(
    					// last username entered by the user
    					'last_username' => $session->get(SecurityContext::LAST_USERNAME),
    					'error'         => $error,
    			
    	);

    }
    
    public function loginCheckAction(){
    	// The security layer will intercept this request
    }
    
    /**
     * @Route("/logout/", name="logout")
     */
    public function  logoutAction(){
    	// The security layer will intercept this request
    	
    }
    
    /**
     * @Template()
     */
    public function registerAction(){
    	// Registrier Formular initialisieren
       $form = $this->createForm(
            new RegistrationType(),
            new Registration()
        );
		// Formular an View übergeben
        return array('form' => $form->createView());
    }
    
    
    /**
     * @Template()
     */
    public function createAction(){
			$em = $this->getDoctrine()->getManager();
			// Formular initialisieren
	    $form = $this->createForm(new RegistrationType(), new Registration());
	
	    $form->bind($this->getRequest());
			
	    // Testen ob das Formular valid ist
	    if ($form->isValid()) {
	    	
	    	$registration = $form->getData();
	     	$user = $registration->getUser();
	    	// Daten aus Formular abgreifen
	    	// unique user ?
	    	$unique = $em->getRepository('DistSysShopBundle:User')->isUserUnique($user->getUsername(), $user->getEmail());
	      // Wenn neuer User, dann Anlegen
				if ($unique){
						
					// Rolle für den USer setzen
					$role = $em->getRepository('DistSysShopBundle:Role')->findOneByName('ROLE_USER');
		      $encoder = $this->container->get('security.encoder_factory')->getEncoder($user);
		        // Passwort setzen
		      $password = $encoder->encodePassword($user->getPassword(), $user->getSalt());
		        
		      //Passwort verschlüsselt in Datenbank schreiben
	
		      $user->setPassword($password);
		      $user->addRole($role);
		        
		      $em->persist($user);
		        
		      
	

		        
		      $em->flush();
		        
		
		      return array('user' => $user);
				}
				
				
	    }
	
			return $this->render('DistSysShopBundle:Security:register.html.twig', array(
					'user' => $user,
					'form' => $form->createView(),
					'error' => "Email oder Username schon registriert!"
	    ));
    }

    


    
}