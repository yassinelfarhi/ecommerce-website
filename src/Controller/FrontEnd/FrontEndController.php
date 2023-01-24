<?php

namespace App\Controller\FrontEnd;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FrontEndController extends AbstractController
{

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

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
        // Get all products
        $products = $this->entityManager->getRepository(Product::class)->findAll();
        return $this->render('front_end/index/listing2.html.twig',[
            'products'=>$products,
        ]);
    }


    #[Route('/products/{idproduct}', name: 'front_show_product')]
    public function products(int $idproduct): Response
    {
        // Get the proiduct by it's id or slug
        $product = $this->entityManager->getRepository(Product::class)->find($idproduct);
        return $this->render('front_end/product/product_page.html.twig',[
            'product'=>$product
        ]);
    }


    #[Route('/collection', name: 'app_collection')]
    public function collection(): Response
    {
        return $this->render('front_end/collection/collection_page.html.twig');
    }

//    #[Route('/listingtest', name: 'app_listingcold')]
//    public function collectiondd(): Response
//    {
//        // Get all products
//        $products = $this->entityManager->getRepository(Product::class)->findAll();
//        return $this->render('front_end/index/listing2.html.twig',[
//            'products'=>$products,
//        ]);
//    }


}
