<?php

namespace App\Controller\Order;

use App\Repository\ProductRepository;
use App\Entity\OrderItems;
use App\Form\OrderItemType;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class OrderItemController extends AbstractController
{
    private $productRepository;
    private $om;

    public function __construct(ProductRepository $productRepository, ObjectManager $om)
    {
        $this->productRepository = $productRepository;
        $this->om = $om;
    }

    /**
     * @Route("/orderItems", name="orderItems.index")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index()
    {
        return $this->render('orderItems/index.html.twig');
    }

    /**
     * @Route("/orderItems/create", name="orderItems.create")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function newOrderItem(Request $request)
    {
        $orderitem = new OrderItems();
        $form = $this->createForm(OrderItemType::class, $orderitem);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $product = $this->productRepository->find($orderitem->getProductId());

            $orderitem->setSku($product->getSku());
            $orderitem->setPrice($product->getPrice());
            $orderitem->setWeight($product->getWeight());
            $orderitem->setTax($product->getTax());
            $this->om->persist($orderitem);
            $this->om->flush();
            return $this->redirectToRoute('orderItems.index');

        }
        return $this->render('orderItems/newOrderItems.html.twig', [
            'orderitem' => $orderitem,
            'form' => $form->createView()
        ]);
    }
}