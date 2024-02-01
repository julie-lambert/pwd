<?php

namespace App\Controller;

use App\Model\Product;
use App\Model\Clothing;
use App\Model\Electronic;
use App\Controller\AuthenticationController;


class ShopController
{

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

        if ($resultClothing) {
            return "clothing";
        } elseif ($resultElectronic) {
            return "electronic";
        } else {
            return false;
        }
    }

    public function showProduct($id_product, $productType): object|string
    {
        $auth = new AuthenticationController();
        if ($auth->profile()) {
            $auth->profile();
            $clothing = new Clothing();
            $electronic = new Electronic();
            $product = new Product();
            if ($productType == "clothing") {
                return $clothing->findOneById($id_product);
            } elseif ($productType == "electronic") {
                return $electronic->findOneById($id_product);
            } else {
                return $product->findOneById($id_product);
            }
        } else {
            $message = "Vous devez être connecté pour accéder à cette page";
            header("refresh:3; url=./login.php");
            return $message;
        }
    }
}
