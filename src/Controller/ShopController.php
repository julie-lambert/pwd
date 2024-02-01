<?php

namespace App\Controller;
use App\Model\Product;
use App\Model\Clothing;
use App\Model\Electronic;


class ShopController{

    public function index(int $page): array 
    {
        $AllProducts = new Product();
        return $AllProducts->findPaginated($page);
    }

    public function productType(int $id): string|false
    {
        
        $clothing = new Clothing();
        $electronic = new Electronic();
        $resultClothing = $clothing->findOneById($id);
        $resultElectronic = $electronic->findOneById($id);

        if($resultClothing){
            return "clothing";
        }elseif($resultElectronic){
            return "electronic";
        }else{
            return false;
        }
    }
}