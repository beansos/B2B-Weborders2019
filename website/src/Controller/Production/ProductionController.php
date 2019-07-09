<?php

namespace App\Controller\Production;

use App\Entity\Orders;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class ProductionController extends AbstractController
{


    private $em;

    Public function __construct(ObjectManager $em)
    {

        $this->em = $em;
    }

    /**
     * @Route("/production", name="production.index")
     * @return Response
     */
    Public function index()
    {
        $allOrders = $this->em->getRepository(Orders::class)->findBy(["status" => 1]);

        $quantity = [];
        $maxBatch = [];
        $batch = [];
        $green = [];

        $lines = [];

        for($i = 0; $i < count($allOrders); $i++) {
            $allOrdersItems[$i] = $allOrders[$i]->orderItems;

            for ($j = 0; $j < count($allOrdersItems[$i]); $j++) {

                $line = (object) array();

                if ($allOrdersItems[$i][$j]->getProductId()->getCategory() > 0 && $allOrdersItems[$i][$j]->getProductId()->getCategory() <= 2){
                    if(!array_key_exists(($allOrdersItems[$i][$j]->getProductId())->getName(), $maxBatch)){
                    $maxBatch[($allOrdersItems[$i][$j]->getProductId())->getName()] = $allOrdersItems[$i][$j]->getProductId()->getBatch();
                    }

                    if (array_key_exists(($allOrdersItems[$i][$j]->getProductId())->getName(), $quantity)) {
                        $quantity[($allOrdersItems[$i][$j]->getProductId())->getName()] += $allOrdersItems[$i][$j]->getQuantity();
                    } else {
                        $quantity[($allOrdersItems[$i][$j]->getProductId())->getName()] = $allOrdersItems[$i][$j]->getQuantity();
                    }

                    $line->id = $allOrdersItems[$i][$j]->getId();
                    $line->enterprise = $allOrdersItems[$i][$j]->getOrderId()->getUserId()->getEnterprise();
                    $line->email = $allOrdersItems[$i][$j]->getOrderId()->getUserId()->getEmail();
                    $line->quantity = $allOrdersItems[$i][$j]->getQuantity();
                    $line->date = $allOrdersItems[$i][$j]->getOrderId()->getDeliveryDate()->format('d M Y');
                    $line->status = $allOrdersItems[$i][$j]->getOrderId()->getStatus();

                    array_push($lines, $line);
                    dump($lines);
                }
            }
        }

        foreach ($maxBatch as $key => $value) {
            $green[$key] = ceil($quantity[$key] + ((15*$quantity[$key])/100));
            $batch[$key] = ceil($green[$key] / $maxBatch[$key]);


        }

        dump("Quantity", $quantity);
        dump("Max Batch", $maxBatch);
        dump("Batch", $batch);
        dump("Green", $green);
        dump($lines);

        return $this->render('/Production/productionSchedule.html.twig', [
            'quantities'    => $quantity,
            'maxBatch'      => $maxBatch,
            'batch'         => $batch,
            'green'         => $green,
            'lines'         => $lines,
        ]);
    }
}



