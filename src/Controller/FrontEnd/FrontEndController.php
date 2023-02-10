<?php

namespace App\Controller\FrontEnd;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use function PHPUnit\Framework\isNull;

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


    #[Route('/products/{product}', name: 'front_show_product')]
    public function products($product): Response
    {

        $resultProducts = $this->entityManager->getRepository(Product::class)->find($product);
        if (is_null($resultProducts)){
            $resultProducts = $this->entityManager->getRepository(Product::class)->findProductBySlug($product);
        }

        // Get the product by its id or slug
        return $this->render('front_end/product/product_page.html.twig',[
            'product'=>$resultProducts
        ]);
    }


    #[Route('/collection/{name}', name: 'app_collection')]
    public function collection($name): Response
    {

        // Get products by collection name
        //$products = $this->entityManager->getRepository(Product::class)->getProductsByCollection('men');
        $products = $this->entityManager->getRepository(Product::class)->findAll();
//        dd($products);
        return $this->render('front_end/index/listing.html.twig',[
            'products'=>$products,
        ]);

    }


}
