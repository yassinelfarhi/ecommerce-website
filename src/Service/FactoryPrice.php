<?php

namespace App\Service;

ini_set('memory_limit', '3G');


use App\Entity\Product;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use Doctrine\Persistence\ManagerRegistry;

class FactoryPrice
{
    
    public $products;
    public $entityManager;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->entityManager = $doctrine->getManager();
    }

    public function readFile() {

        $xlxs = new Xlsx();
        $content = $xlxs->load(__DIR__.'/../../var/data/yassin_factory.xlsx');
        $rows = $content->getActiveSheet()->toArray();
        $keys = array_shift($rows);
        $this->products = $rows;
    }



    public function importProducts(){

        
        if ( count($this->products) > 0 ) {
            
            
            foreach($this->products as $product) {

                $productEntity = new Product();
                $images = [];
                $productEntity->setApiId($product[1]);
                $productEntity->setName($product[14]);
                $productEntity->setDescription($product[18]);
                $productEntity->setCategory($product[7]);
                $productEntity->setComposition($product[15]);
                $productEntity->setCategory($product[6]);
                $productEntity->setPrice($product[9]);
                $productEntity->setRetailPrice($product[10]);
                $productEntity->setMainImage($product[22]);
                $images[] = $product[12];
                $images[] = $product[13];
                $productEntity->setImages($images);


                $this->entityManager->persist($productEntity);
                $this->entityManager->flush();
                
                break;
            }
        }
    }
}




