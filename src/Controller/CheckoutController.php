<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Stripe;

class CheckoutController extends AbstractController
{
    #[Route('/checkout/cart', name: 'app_checkout')]
    public function index(): Response
    {
        return $this->render('checkout/index.html.twig', [
            'controller_name' => 'CheckoutController',
        ]);
    }



    #[Route('/checkout/payement{$gateway}', name: 'app_checkout_pay')]
    public function makePayement($gateway) {

        if ($gateway == "stripe") {
          
            Stripe\Stripe::setApiKey($_ENV["STRIPE_SECRET"]);
        
            $checkout_session = Stripe\Checkout\Session::create([
                'line_items' => [[
                  'price' => '{{PRICE_ID}}',
                  'quantity' => 1,
                ]],
                'mode' => 'payment',
                'success_url' => $YOUR_DOMAIN . '/success.html',
                'cancel_url' => $YOUR_DOMAIN . '/cancel.html',
              ]);

              return "success";

        } elseif ($gateway == "paypal") {

            //paypal payement logic









            return "paypal success";

        }


    }


    // public function 
}
