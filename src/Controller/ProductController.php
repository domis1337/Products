<?php

namespace App\Controller;

use App\Entity\Products;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ProductController extends AbstractController
{
	
	/**
     *
     * @Route("/products", name="list_products", methods={"GET"})
     */
    public function listProducts(Request $request): Response
    {	
		$products = $this->getDoctrine()
					->getRepository(Products::class)
					->findAll();
		
        return $this->render('products/index.html.twig', [
            'products' => $products,
        ]);
    }
	
	#[Route('/createproduct', name: 'create_product_form')]
	public function createProductForm(): Response
    {
        return $this->render('products/createproduct.html.twig', [
            'controller_name' => 'CreateProductForm',
        ]);
    }
	
	/**
     *
     * @Route("/createdproduct", name="created_product", methods={"GET"})
     */
	public function createProduct(ValidatorInterface $validator, Request $request): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
		
		$name = $request->query->get('aname');
		$amount = $request->query->get('aamount');
		$currency;
		switch ($request->query->get('acurrency')) {
			case 1:
				$currency = 'EUR';
				break;
			case 2:
				$currency = 'USD';
				break;
		}

        $product = new Products();
        $product->setName($name);
		$product->setAmount($amount);
		$product->setCurrency($currency);
		$product->setCreatedAt(new \DateTime());
		
		$errors = $validator->validate($product);
        if (count($errors) > 0) {
            return new Response((string) $errors, 400);
        }
        
        $entityManager->persist($product);
        $entityManager->flush();
		
		return $this->render('products/createdproduct.html.twig', [
            'product' => $product->getId(), 'name' => $product->getName(),
        ]);
    }
	
	/**
     *
     * @Route("/updateproduct", name="update_product", methods={"GET"})
     */
	public function updateProduct(Request $request): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
		$id = $searchValue = $request->query->get('uproductid');
        $product = $entityManager->getRepository(Products::class)->find($id);
		
		$name = $request->query->get('uname');
		$amount = $request->query->get('uamount');

        if (!$product) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }
		
		if(!empty($name)){
			$product->setName($name);
		}
		
		if(!empty($amount)){
			$product->setAmount($amount);
		}
		
		$entityManager->flush();
		
		return $this->redirectToRoute('list_products', [
            
        ]);
    }
	
}