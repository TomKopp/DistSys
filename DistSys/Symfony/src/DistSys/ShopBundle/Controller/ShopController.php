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
  public function indexAction($categoryId) {
    $prodQantityPerSite = 8;
    $em = $this->getDoctrine()->getManager();
    $request = $this->getRequest();

    // Pagination
    //this or $em?
    $allProductsInCategory = $this->getRepository('DistSysShopBundle:Product')->getProductsByAttributes($categoryId);
    $request->get('pagination') ? $currentSite = $request->get('pagination') : $currentSite = 0;
    for ($i = 0; ciel(count($allProductsInCategory) / $prodQantityPerSite); $i++) {
      if ($currentSite === $i) {
        $pagination[$i]['active'] = TRUE;
      } else {
        $pagination[$i]['active'] = FALSE;
      }
    }


    $products = $em->getRepository('DistSysShopBundle:Product')->getProductsByAttributes($categoryId, array('offset' => ($currentSite * $prodQantityPerSite), 'limit' => 8));
    return $this->render(
        'DistSysShopBundle:Shop:category.html.twig', array(
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
  public function showProductDetailAction($productId) {
    $to_render = array();
    $doctrine = $this->getDoctrine();
    $repository = $doctrine->getRepository('DistSysShopBundle:Product');
    $to_render['product'] = $repository->find($productId);
    $to_render['lastUrl'] = $this->getRequest()->headers->get('referer');

    # get Array for Attributes, sorted by Category
//    $attributeArray = array();
    $attributes = $to_render['product']->getAttributes();
    foreach ($attributes as $attribute) {
      $categories[$attribute->getCategory()->getCategoryName()][] = $attribute;
    }

    $to_render['categories'] = $categories;

    return $this->render('DistSysShopBundle:Shop:productDetail.html.twig', $to_render);
  }

  #List of products for search request

  public function searchResultAction() {
    $request = $this->getRequest();
    $session = $this->getRequest()->getSession();
    $em = $this->getDoctrine()->getManager();
    #save search in sessionvariable to conserve the result in case of "back" from a product detail...
    if (!$session->has('search')) {
      $session->set('search', '');
    }
    #search string should not start with a space
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
//    $category = $doctrine->getRepository('DistSysShopBundle:AttributeType')->findByName('category');
//    $category->getAttributes();
    
    $relatedProducts = array_slice(shuffle($products), 0, 4);

    return $this->render('DistSysShopBundle:Default:relatedProducts.html.twig', array('relatedProducts' => $relatedProducts));
  }

  /**
   * Create and render the slider on the homepage
   * 
   * @return render twig
   */
  public function renderSliderAction() {
    $categories = $this->getDoctrine()->getRepository('DistSysShopBundle:Attribute')->findByCategory(6);
    foreach ($categories as $category) {
      $products[$category->getAttributename()] = $this->getDoctrine()->getRepository('DistSysShopBundle:Product')->getProductsByAttributes($category, array('limit' => 4));
    }

    return $this->render('DistSysShopBundle:Default:slider.html.twig', array('categories' => $products));
  }

}
