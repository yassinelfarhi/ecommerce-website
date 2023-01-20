<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FrontEndController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('__template_multikart/index.html.twig', [
            'controller_name' => 'FrontEndController',
        ]);
    }

    #[Route('/listing', name: 'app_listing')]
    public function listing(): Response
    {
        return $this->render('front_end/index/listing.html.twig');
    }


    #[Route('/products', name: 'app_products')]
    public function products(): Response
    {
        return $this->render('front_end/product/product_page.html.twig');
    }


    #[Route('/collection', name: 'app_collection')]
    public function collection(): Response
    {
        return $this->render('front_end/collection/collection_page.html.twig');
    }

}
