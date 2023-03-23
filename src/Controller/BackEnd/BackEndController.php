<?php

namespace App\Controller\BackEnd;

use App\Entity\Product;
use App\Form\ProductType;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class BackEndController extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var RequestStack
     */
    private $request;

    /**
     * @var PaginatorInterface
     */
    private $paginator;



    public function __construct(EntityManagerInterface $entityManager, RequestStack $request,PaginatorInterface $paginator)
    {
        $this->entityManager = $entityManager;
        $this->request = $request;
        $this->paginator = $paginator;
    }


    #[Route('/dashboard', name: 'back_dashboard')]
    public function index(): Response
    {
        return $this->render('back_end/dashboard/dashboard.html.twig');
    }

    #[Route('/products/list/{limit}', name: 'back_product_listing', requirements: ['page' => '\d+'], defaults: ['limit' => 10])]
    public function productListing(int $limit, Request $request): Response
    {
        $data = $this->entityManager->getRepository(Product::class)->findAll();
        $products = $this->paginator->paginate(
             $data,
             $request->query->get('page',1),
             $limit
         );

        return $this->render(
                'back_end/product/product_list.html.twig', [
                    'products' => $products
            ]
        );
    }


    #[Route('/products/add', name: 'add_product')]
    public function addProduct(Request $request): Response
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        return $this->render(
            'back_end/product/add-product.html.twig', [
                'form' => $form
            ]
        );
    }

}
