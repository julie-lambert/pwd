<?php

namespace App\Controller;

use App\Model\Product;
use App\Model\Clothing;
use App\Model\Electronic;
use App\Controller\AuthenticationController;
use App\Model\Cart;
use App\Model\ProductCart;
use DateTime;

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

    public function addProductToCart($product_id, $quantity): void
    {
        $auth = new AuthenticationController();
        if ($auth->profile()) {
            $userId = $_SESSION['user']->getId();
            $productModel = new Product();
            $product =$productModel->findOneById($product_id);
            $cart = new Cart(); 
           if($cart->findOneByUserId(user_id: $userId) == false){
                $cart->setTotal($product->getPrice() * $quantity);
                $cart->setUser_id($userId);
                $cart->setCreated_at(new DateTime());
                $cart->setUpdated_at(null);
                $cart->createCart();
            
                // On ajoute le produit au panier
                $productCart = new ProductCart();
                $productCart->setQuantity($quantity);
                $productCart->setProduct_id($product_id);
                $productCart->setCart_id($cart->getId());
                $productCart->setCreated_at(new DateTime());
                $productCart->setUpdated_at(null);
                $productCart->createProductCart();

                $cart->setTotal($product->getPrice() * $quantity);
                $cart->setUpdated_at(new DateTime());
                $cart->updateCart();

            } 

            

        } else {
            header("Location: ./login.php");
        }
    }
}
