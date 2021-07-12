<?php

namespace App\Controller;

use App\Entity\Orders;
use App\Entity\Products;
use App\Entity\OrdersProducts;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class OrderController extends AbstractController
{
	
	/**
     *
     * @Route("/", name="list_orders", methods={"GET"})
     */
    public function listOrders(Request $request): Response
    {	
		$searchValue = $request->query->get('sfield');
		$selectedSearchValue = $request->query->get('svalue');
		$selectedFilterValue = $request->query->get('fvalue');
		
		
		switch ($selectedSearchValue) {
			case 1:
				$orders = $this->getDoctrine()
					->getRepository(Orders::class)
					->findByUseridField($searchValue, $selectedFilterValue);
				break;
			case 2:
				$orders = $this->getDoctrine()
					->getRepository(Orders::class)
					->findByEmailField($searchValue, $selectedFilterValue);
				break;
			default:
				$orders = $this->getDoctrine()
					->getRepository(Orders::class)
					->findAllOrders($searchValue, $selectedFilterValue);
						
		}
			
        return $this->render('orders/index.html.twig', [
            'orders' => $orders, 'searchValue' => $searchValue, 'selectedSearchValue' => $selectedSearchValue, 'selectedFilterValue' => $selectedFilterValue,
        ]);
    }
	
	#[Route('/createorder', name: 'create_order_form')]
	public function createOrderForm(): Response
    {
		$products = $this->getDoctrine()
					->getRepository(Products::class)
					->findAll();
		
        return $this->render('orders/createorder.html.twig', [
            'controller_name' => 'CreateOrderForm', 'products' => $products,
        ]);
    }
	
	/**
     *
     * @Route("/createdorder", name="created_order", methods={"GET"})
     */
	public function createOrder(ValidatorInterface $validator, Request $request): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
		
		$userid = $request->query->get('ouserid');
		$title = $request->query->get('otitle');
		$email = $request->query->get('oemail');
		$productids = $request->query->get('checkBox');
		

        $order = new Orders();
        $order->setUserId($userid);
		$order->setTitle($title);
		$order->setEmail($email);
		$order->setCreatedAt(new \DateTime());
		
		$errors = $validator->validate($order);
        if (count($errors) > 0) {
            return new Response((string) $errors, 400);
        }
        
        $entityManager->persist($order);
        $entityManager->flush();
		
		
		if(!empty($productids)){
			


			$zl = 0;
			foreach ($productids as $pr){
				
				$em = $this->getDoctrine()->getManager();
				$pr = $em->getRepository(Products::class)->find($pr);
			
				$orderproduct = new OrdersProducts();
				$orderproduct->setOrderId($order);
				$orderproduct->setProductId($pr);
				$orderproduct->setCreatedAt(new \DateTime());
			
				$em->persist($orderproduct);
				$em->flush();
			
				++$zl;
			}

		}
		
		
		return $this->render('orders/createdorder.html.twig', [
            'order' => $order->getId(), 'title' => $order->getTitle(),
        ]);
    }
	
	/**
     *
     * @Route("/vieworder", name="view_order", methods={"GET"})
     */
	public function viewOrder(Request $request): Response
    {
        $searchValue = $request->query->get('vorderid');
	
		$order = $this->getDoctrine()
			->getRepository(Orders::class)
			->findOneByIdField($searchValue);
			
		
		$products = $this->getDoctrine()
			->getRepository(Products::class)
			->findOrderProducts($searchValue);
			
		
        return $this->render('orders/vieworder.html.twig', [
            'order' => $order, 'products' => $products,
        ]);
    }
	
	/**
     *
     * @Route("/deleteproduct", name="delete_product", methods={"GET"})
     */
	public function deleteProduct(Request $request): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
		$orderid = $request->query->get('oorderid');
		$productids = $request->query->get('checkBox');
		
		if(!empty($productids)){


			$zl = 0;
			foreach ($productids as $pr){
				
				$em = $this->getDoctrine()->getManager();
				$orderproduct = $this->getDoctrine()
				->getRepository(OrdersProducts::class)
				->findByIdField($orderid, $pr);
				
				foreach ($orderproduct as $op){
					
					$opid = $op->getId();
					$oproduct = $em->getRepository(OrdersProducts::class)->find($opid);
					
					$oproduct->setProductId(NULL);
					$em->flush();
				}
				
				++$zl;
			}

		}
		
		
		
		return $this->redirectToRoute('list_orders', [
            
        ]);
    }
	
}