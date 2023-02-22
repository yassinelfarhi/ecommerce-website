<?php

namespace App\Controller\FrontEnd;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
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
     * @var RequestStack
     */
    private $request;



    public function __construct(EntityManagerInterface $entityManager, RequestStack $request)
    {
        $this->entityManager = $entityManager;
        $this->request = $request;
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
        return $this->render('front_end/index/listing.html.twig',[
            'products'=>$products,
        ]);

    }

    #[Route('/checkout', name: 'app_checkout')]
    public function checkout(): Response
    {

        // Get products by collection name
        //$products = $this->entityManager->getRepository(Product::class)->getProductsByCollection('men');
        return $this->render('front_end/checkout/checkout.html.twig',[

        ]);

    }

    #[Route('/addtocart/', name: 'app_addtoacrt', methods: 'POST')]
    public function addtocart(Request $request): Response
    {

        $cart = $request->request->get('cart');
        $session = $this->request->getSession();
        $session->set('cart',$cart);
        $cart = $session->get('cart');

        $decoded = json_decode($cart);
        foreach ($decoded as $key => $item){
            $stdClass =  get_object_vars($item);
            $product =  $this->entityManager->getRepository(Product::class)->find($stdClass['id']);
            return $this->render('/front_end/cart/_cart.html.twig', [
                'product' => $product,
                'count' => $stdClass['count']
            ]);

        }

//        $session->remove('my_variable');

        return new JsonResponse('Ok');

    }


}
