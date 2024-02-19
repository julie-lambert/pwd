<?php

namespace App\Controller;

use App\Model\Product;
use App\Model\Clothing;
use App\Model\Electronic;
use App\Controller\AuthenticationController;
use App\Model\Cart;
use App\Model\ProductCart;



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

    public function showProduct($id_product, $productType = null): object|string
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

    public function addProductToCart($product_id, $quantity, $user_id): array
    {
        $auth = new AuthenticationController();
        if ($auth->profile()) {
            $userId = $user_id;
            $productModel = new Product();
            $product = $productModel->findOneById($product_id);
            $cart = new Cart();
            $request = $cart->findOneByUserId($userId);
            if ($request == false) {
                $cart->setTotal($product->getPrice() * $quantity);
                $cart->setUser_id($userId);
                $cart->createCart();

                // On ajoute le produit au panier
                $productCart = new ProductCart();
                $productCart->setQuantity($quantity);
                $productCart->setProduct_id($product_id);
                $productCart->setCart_id($cart->getId());
                $productCart->createProductCart();

                $cart->setTotal($product->getPrice() * $quantity);
                $cart->updateCart();
                $_SESSION["cart"] = $cart;
                $_SESSION["productCart"][] = $productCart;
                $result = ["success" => true, "message" => "Le produit a bien été ajouté au panier"];
            } else {

                //On récupère les produits du panier pour les mettre dans la session
                $_SESSION["cart"] = $request;
                $productCartModel = new ProductCart();
                $productCarts = $productCartModel->findAllByCartId($request->getId());
                $_SESSION["productCart"] = [];
                foreach ($productCarts as $productCart) {
                    $_SESSION["productCart"][] = $productCart;
                }

                //Si on a deja un panier existant on vérifie si le produit est deja dans le panier
                $foundProduct = null;
                foreach ($_SESSION["productCart"] as $productCart) {
                    if ($productCart->getProduct_id() == $product_id) {
                        $foundProduct = $productCart;
                        break;
                    }
                }
                if ($foundProduct != null) {
                    $foundProduct->setQuantity($foundProduct->getQuantity() + $quantity);
                    $foundProduct->updateProductCart();
                    $cart->setTotal($cart->getTotal() + ($product->getPrice() * $quantity));
                    $cart->updateCart();
                    $_SESSION["cart"] = $cart;
                    $result = ["success" => true, "message" => "La quantité du produit a bien été modifiée"];
                } else {

                    //Si le produit n'est pas dans le panier on l'ajoute
                    $productCart = new ProductCart();
                    $productCart->setQuantity($quantity);
                    $productCart->setProduct_id($product_id);
                    $productCart->setCart_id($_SESSION["cart"]->getId());
                    $productCart->createProductCart();
                    $cart = $_SESSION["cart"];
                    $cart->setTotal($cart->getTotal() + ($product->getPrice() * $quantity));
                    $cart->updateCart();
                    $_SESSION["cart"] = $cart;
                    $_SESSION["productCart"][] = $productCart;
                    $result = ["success" => true, "message" => "Le produit a bien été ajouté au panier"];
                }
            }
        } else {
            $result = ["success" => false, "message" => "Vous devez être connecté pour ajouter un produit au panier"];
            // header("Location: ./login.php");
        }
        return $result;
    }

    public function deleteProductCart($idProduct): array
    {
        $result = [];
        $productCartModel = new ProductCart();
        $productCart = $productCartModel->findOneById($idProduct, $_SESSION["cart"]->getId());

        if ($productCart) {
            if ($productCart->deleteProductCart($idProduct)) {
                $cart = $_SESSION["cart"];
                $productDetails = $this->showProduct($idProduct);
                $cart->setTotal($cart->getTotal() - ($productCart->getQuantity() * $productDetails->getPrice()));
                $cart->updateCart();
                $_SESSION["cart"] = $cart;
                unset($_SESSION["productCart"]);
                // récupération des produits du panier
                foreach ($productCartModel->findAllByCartId($_SESSION["cart"]->getId()) as $productCart) {
                    $_SESSION["productCart"][] = $productCart;
                }
                $result = ["success" => true, "message" => "Le produit a bien été supprimé du panier"];
            } else {
                $result = ["success" => false, "message" => "Une erreur est survenue lors de la suppression du produit"];
            }
        } else {
            $result = ["success" => false, "message" => "Le produit n'existe pas dans le panier"];
        }
        return $result;
    }

    public function updateProductCart($idProduct, $quantity): array
    {
        $result = [];
        $productCartModel = new ProductCart();
        $productCart = $productCartModel->findOneById($idProduct, $_SESSION["cart"]->getId());
        if ($productCart) {
            $oldQuantity = $productCart->getQuantity();
            $productCart->setQuantity($quantity);
            if ($productCart->updateProductCart()) {
                $cart = $_SESSION["cart"];
                $productDetails = $this->showProduct($idProduct);
                $cart->setTotal($cart->getTotal() - ($oldQuantity * $productDetails->getPrice()) + ($quantity * $productDetails->getPrice()));
                $cart->updateCart();
                $_SESSION["cart"] = $cart;
                unset($_SESSION["productCart"]);
                // récupération des produits du panier
                foreach ($productCartModel->findAllByCartId($_SESSION["cart"]->getId()) as $productCart) {
                    $_SESSION["productCart"][] = $productCart;
                }
                $result = ["success" => true, "message" => "La quantité du produit a bien été modifiée"];
            } else {
                $result = ["success" => false, "message" => "Une erreur est survenue lors de la modification de la quantité"];
            }
        } else {
            $result = ["success" => false, "message" => "Le produit n'existe pas dans le panier"];
        }
        return $result;
    }

    public function validateCart($user_id): array
    {
        $result = [];
        $cartModel = new Cart();
        $cartModelResult = $cartModel->findOneByUserId($user_id);
        if ($cartModelResult) {
            $cartId = $cartModelResult->getId();
            $productCartModel = new ProductCart();
            $productCarts = $productCartModel->deleteProductCartByCartId($cartId);
            if ($productCarts) {
                $cart = $cartModel->deleteCart($user_id);
                if ($cart) {
                    $result = ["success" => true, "message" => "Le panier a bien été validé"];
                    unset($_SESSION["cart"]);
                    unset($_SESSION["productCart"]);
                } else {
                    $result = ["success" => false, "message" => "Une erreur est survenue lors de la validation du panier"];
                }
            } else {
                $result = ["success" => false, "message" => "Une erreur est survenue lors de la validation du panier"];
            }
        } else {
            $result = ["success" => false, "message" => "Le panier n'existe pas"];
        }
        return $result;
    }
}
