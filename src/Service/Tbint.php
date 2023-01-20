<?php

namespace App\Service;

ini_set('memory_limit', '3G');

use App\Entity\Product;
use Doctrine\ORM\EntityManager;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Finder\Finder;


class Tbint
{
    const FTP_URL = "ftp://available:stockcheck@ftp.tbint.de/";
    public $csv;
    public $products;
    public $entityManager;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->entityManager = $doctrine->getManager();
    }

    public function getCSV() {

        //getting files from server
        $finder = new Finder();
        $finder->files()->in(self::FTP_URL)->name('Product_List_EN*');

        if ( $finder->hasResults() ) {
            
            foreach( $finder as $file ) {
                $this->csv = fopen($file->getPathname(),"r");
            }

            $keys = fgetcsv($this->csv,1000,";");
            $count = 0 ;
            while ( ( $record = fgetcsv($this->csv,1000,";") ) !== FALSE && $count < 10 ) {

                if (count($keys) == count($record)) {
                    $this->products[] = array_combine($keys,$record);

                }

                $count++;
            
               }

            }
        
        return $this->products;
    }

    public function importProducts() {

        if ( count($this->products) > 0 ) {
            
            
            foreach($this->products as $product) {

                $productEntity = new Product();
                $productEntity->setApiId($product['products_id']);
                $productEntity->setEan($product['products_ean']);
                $productEntity->setName($product['products_name']);
                $productEntity->setDescription($product['products_description']);
                $productEntity->setCategory($product['categories_name']);
                $productEntity->setComposition($product['products_composition']);
                $productEntity->setQuantity($product['products_quantity']);
                $productEntity->setWeight($product['products_weight']);
                $productEntity->setMainImage($product['products_image']);

                $photos = [];

                for ($i=1; $i < 27 ; $i++) { 

                    if (!empty($product['products_image_'.$i])) {

                        $photos[] = $product['products_image_'.$i];
                        $productEntity->setImages($photos);

                    }
                  
                }

                $productEntity->setPrice($product['products_price']);
                $productEntity->setRetailPrice($product['retail_price']);


                $productEntity->setComposition($product['products_composition']);

                if (!empty($productEntity)) {
                    $this->entityManager->persist($productEntity);
                    $this->entityManager->flush();
                }
             
            }
        }  

        
    }
}




