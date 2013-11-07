<?php

namespace DistSys\ShopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ShopController extends Controller {

  /**
   * List of products selected by category
   * 
   * @param type $categoryId
   * @return render twig
   */
  public function categoryAction($categoryId) {
    $prodQantityPerSite = 3;
    $doctrine = $this->getDoctrine();
    $request = $this->getRequest();
    $pagination = NULL;

    // Pagination
    $allProductsInCategory = $doctrine->getRepository('DistSysShopBundle:Product')->getProductsByAttribute($categoryId);
    
    
    $request->get('pagination') ? $currentSite = $request->get('pagination') : $currentSite = 0;
    
    for ($i = 0; $i < ceil(count($allProductsInCategory) / $prodQantityPerSite); $i++) {
      if ($currentSite === $i) {
        $pagination[$i]['active'] = TRUE;
      } else {
        $pagination[$i]['active'] = FALSE;
      }
    }

    $products = $doctrine->getRepository('DistSysShopBundle:Product')->getProductsByAttribute($categoryId, array('offset' => ($currentSite * $prodQantityPerSite), 'limit' => $prodQantityPerSite));
    $em = $this->getDoctrine()->getManager();
    
    for ($i = 0; $i < count($products); $i++){
    	$products[$i]->teaser = $em->getRepository('DistSysShopBundle:GalleryItem')->findOneByProduct($products[$i]->getId());
    	//$products[$i]->teaser = $products[$i]->getGalleryItems()->first();
    }
    
    return $this->render(
        'DistSysShopBundle:Shop:category.html.twig', array(
        'products' => $products,
        'pagination' => $pagination,
        'categoryId' => $categoryId
        )
    );
  }
  
  public function categoryPartAction($categoryId) {
  	$prodQantityPerSite = 3;
  	$doctrine = $this->getDoctrine();
  	$request = $this->getRequest();
  	$pagination = NULL;
  
  	// Pagination
  	$allProductsInCategory = $doctrine->getRepository('DistSysShopBundle:Product')->getProductsByAttribute($categoryId);
  
  
  	$request->get('pagination') ? $currentSite = $request->get('pagination') : $currentSite = 0;
  
  	for ($i = 0; $i < ceil(count($allProductsInCategory) / $prodQantityPerSite); $i++) {
  		if ($currentSite === $i) {
  			$pagination[$i]['active'] = TRUE;
  		} else {
  			$pagination[$i]['active'] = FALSE;
  		}
  	}
  
  	$products = $doctrine->getRepository('DistSysShopBundle:Product')->getProductsByAttribute($categoryId, array('offset' => ($currentSite * $prodQantityPerSite), 'limit' => $prodQantityPerSite));
  	$em = $this->getDoctrine()->getManager();
  
  	for ($i = 0; $i < count($products); $i++){
  		$products[$i]->teaser = $em->getRepository('DistSysShopBundle:GalleryItem')->findOneByProduct($products[$i]->getId());
  		//$products[$i]->teaser = $products[$i]->getGalleryItems()->first();
  	}
  
  	return $this->render(
  			'DistSysShopBundle:Shop:categoryPart.html.twig', array(
  					'products' => $products,
  					'pagination' => $pagination,
  					'categoryId' => $categoryId
  			)
  	);
  }

  /**
   * Product detail page
   * 
   * @param type $productId
   * @return render twig
   */
  public function productAction($productId) {
    $to_render = array();
    $to_render['product'] = $this->getDoctrine()->getRepository('DistSysShopBundle:Product')->find($productId);
    $to_render['lastUrl'] = $this->getRequest()->headers->get('referer');
    $to_render['categories'] = NULL;
    
    $to_render['product']->teaser = $this->getDoctrine()->getRepository('DistSysShopBundle:GalleryItem')->findOneByProduct($productId);
    

    // get Array for Attributes, sorted by Category
//    $attributes = $to_render['product']->getAttributes();
//    foreach ($attributes as $attribute) {
//      $categories[$attribute->getCategory()->getCategoryName()][] = $attribute;
//    }
//    $to_render['categories'] = $categories;

    if ($to_render['product']) {
      foreach ($to_render['product']->getAttributes() as $attribute) {
        $to_render['categories'][$attribute->getAttributeType()->getName()][] = $attribute;
      }
    } else {
      $to_render['product'] = NULL;
    }

    return $this->render('DistSysShopBundle:Shop:product.html.twig', $to_render);
  }

  public function searchResultAction() {
    // List of products for search request
    $request = $this->getRequest();
    $session = $this->getRequest()->getSession();
    // save search in sessionvariable to conserve the result in case of "back" from a product detail...
    if (!$session->has('search')) {
      $session->set('search', '');
    }

    // search string should not start with a space
    if (trim($request->get('search')) != '') {
      $session->set('search', trim($request->get('search')));
    }
    $searched_string = $session->get('search');
    #search_string can have more than one word
    $searchArray = explode(' ', $searched_string);
    $products = $this->getDoctrine()->getRepository('DistSysShopBundle:Product')->findAll();
    $results = array();
    $anz = 0;
    $found = array();
    #go through all products
    foreach ($products as $product) {

      $arraykey = 0;
      $foundcomplete = false;
      #check for each word from the search string seperatly
      foreach ($searchArray as $search_item) {
        $found[$arraykey] = false;
        if (strpos(strtolower($product->getDescription()), strtolower($search_item)) !== false) {
          $found[$arraykey] = true;
        }
        if (strpos(strtolower($product->getTeaser()), strtolower($search_item)) !== false) {
          $found[$arraykey] = true;
        }
        if (strpos(strtolower($product->getProductName()), strtolower($search_item)) !== false) {
          $found[$arraykey] = true;
        }
        if (strpos($product->getId(), $search_item) !== false) {
          $found[$arraykey] = true;
        }
        #search through the attributenames
        $attributes = $product->getAttributes();
        foreach ($attributes as $attribute) {
          if (strpos(strtolower($attribute->getAttributename()), strtolower($search_item)) !== false) {
            $found[$arraykey] = true;
          }
        }

        $arraykey++;
      }
      #check that every word from the serach was found in one product
      $foundcomplete = true;
      for ($i = 0; $i < $arraykey; $i++) {
        #stays only true if all words where found in the product
        if ($found[$i] == false) {
          $foundcomplete = false;
        }
      }
      if ($foundcomplete == true) {
        $anz++;
        $results[$anz] = $product;
      }
    }
    $pagination = array();
    $k = 1;
    #set number of pagination sites
    for ($i = 0; $i < $anz; $i+=8) {
      $pagination[]['current'] = $k;
      $k++;
    }
    #get current pagination
    if ($request->get('pagination')) {
      $currentSite = $request->get('pagination');
      $current = (($currentSite - 1) * 8) + 1;
    } else {
      $current = 1;
      $currentSite = 1;
    }
    return $this->render(
        'DistSysShopBundle:Shop:showResults.html.twig', array(
        'searched_string' => $searched_string,
        'anz' => $anz,
        'results' => $results,
        'sites' => $pagination,
        'current' => $current,
        'currentSite' => $currentSite,
        'maxSite' => ($k - 1),
        )
    );
  }

  /**
   * Create and render related Products by same category
   * 
   * @param int $productId
   * @return render twig
   */
  public function renderRelatedProducts($productId) {
    $doctrine = $this->getDoctrine();
    $products = $doctrine->getRepository('DistSysShopBundle:Product')->findAll();
    $relatedProducts = array_slice(shuffle($products), 0, 4);
//    $product = $doctrine->getRepository('DistSysShopBundle:Product')->find($productId);
//    $attrType = $doctrine->getRepository('DistSysShopBundle:AttributeType')->findOneByName('category');
//    $relatedProducts = $doctrine->getRepository('DistSysShopBundle:Product')->getProductsByAttribute($attrType->getId(), array('limit' => 4));
//    $category->getAttributes();

    return $this->render('DistSysShopBundle:Default:relatedProducts.html.twig', array('relatedProducts' => $relatedProducts));
  }

  /**
   * Create and render the slider on the homepage
   * 
   * @return render twig
   */
  public function renderSliderAction() {
    $doctrine = $this->getDoctrine();
    $attrType = $doctrine->getRepository('DistSysShopBundle:AttributeType')->findOneByName('category');
    $categories = $doctrine->getRepository('DistSysShopBundle:Attribute')->findByAttributeType($attrType->getId());
    foreach ($categories as $category) {
      $products[$category->getName()] = $this->getDoctrine()->getRepository('DistSysShopBundle:Product')->getProductsByAttribute($category->getId(), array('limit' => 4));
    }

    return $this->render('DistSysShopBundle:Default:slider.html.twig', array('categories' => $products));
  }

}
