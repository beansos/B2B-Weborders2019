<?php

namespace App\Controller\Order;

use App\Entity\OrderItems;
use App\Entity\Orders;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class OrderForm extends AbstractController
{
    private $em;

    Public function __construct(ObjectManager $em)
    {

        $this->em = $em;
    }

    /**
     * @Route("/orders", name="orders.index")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    Public function index()
    {
        return $this->render('orders/index.html.twig');
    }

    /**
     * @Route("orders/create", name="orders.create")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    Public function newOrder(Request $request)
    {

        $allProducts = $this->em->getRepository('App:Products')->findAll();
        $allProductsQuotidien = $this->em->getRepository('App:Products')->findBy(['category' => 1]);
        $allProductscatDecouverte = $this->em->getRepository('App:Products')->findBy(['category' => 2]);
        $allProductsconso = $this->em->getRepository('App:Products')->findBy(['category' => 3]);
        dump($_POST);

//        dump($allProducts);

        if($_POST != null){

            $user = $this->em->getRepository('App:Users')->findOneBy(['email'=> $_POST['email']]);
            if ($user == null){
                return $this->redirectToRoute('orders.create');

            }
            $totalExcludingTax = 0;
            $totalTax = 0;
            $totalWeight = 0;

            $order = new Orders();
            $order->setUserId($user);

            $i = 0;
            foreach ($_POST["quantity"] as $key => $value) {
                if($value < 0 || $value > 500){
                    return $this->redirectToRoute('orders.create');
                }
                elseif($value > 0) {
                    dump("productID : ".$key." Quantity : ".$value);

                    $orderItem = new OrderItems();
                    $orderItem->setOrderId($order);
                    $orderItem->setProductId($allProducts[$i]);
                    $orderItem->setSku($allProducts[$i]->getSku());
                    $orderItem->setQuantity($value);

                    if ($allProducts[$i]->getPrice() * $value > 100000) {
                        return $this->redirectToRoute('orders.create');
                    }
                    $orderItem->setPrice($allProducts[$i]->getPrice() * $value);

                    if ($allProducts[$i]->getWeight() * $value > 10000) {
                        return $this->redirectToRoute('orders.create');
                    }
                    $orderItem->setWeight($allProducts[$i]->getWeight() * $value);

                    if ($allProducts[$i]->getTax() > 100) {
                        return $this->redirectToRoute('orders.create');
                    }
                    $orderItem->setTax($allProducts[$i]->getTax());
                    dump($orderItem);
                    $totalExcludingTax += $allProducts[$i]->getPrice() * $value;
                    $totalTax += (($allProducts[$i]->getPrice() + ($allProducts[$i]->getPrice() * $allProducts[$i]->getTax() / 100)) * $value);
                    $totalWeight += $allProducts[$i]->getWeight() * $value;

                    $order->addOrderItem($orderItem);
                }
                $i++;
            }

            if ($totalExcludingTax <= 0 || $totalTax <= 0) {
                return $this->redirectToRoute('orders.create');
            }
            $order->setFrequency(0);
            $order->setStatus(0);
            if(new \DateTime($_POST['deliveryDate']) < new \DateTime('now') || new \DateTime($_POST['deliveryDate']) > date_add(new \DateTime('now'), date_interval_create_from_date_string('60 days'))) {
                return $this->redirectToRoute('orders.create');
            }
            $order->setDeliveryDate(new \DateTime($_POST['deliveryDate']));
            $order->setTotalExcludingTax($totalExcludingTax);
            $order->setTotalTax($totalTax);
            $order->setTotalWeight($totalWeight);

            dump($order);
            $this->em->persist($order);
            $this->em->flush();
            return $this->redirectToRoute('orders.confirm');
        }

        return $this->render('orders/newOrders.html.twig', [
            'allProducts' => $allProducts,
            'allProductsQuotidien' => $allProductsQuotidien,
            'allProductsDecouverte' => $allProductscatDecouverte,
            'allProductsConso' => $allProductsconso,
            //'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/orders/confirm", name="orders.confirm")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    Public function confirmation()
    {
        return $this->render('orders/confirmOrder.html.twig');
    }
}