<?php

namespace App\Model;


use PDO;
use App\Abstract\Database;

class ProductCart
{
  public function __construct(
    private ?int $id = null,
    private ?int $quantity = null,
    private ?int $product_id = null,
    private ?int $cart_id = null,
    private ?PDO $pdo = null

  ) {
  }

  /**
   * Get the value of id
   */
  public function getId()
  {
    return $this->id;
  }

  /**
   * Set the value of id
   *
   * @return  self
   */
  public function setId($id)
  {
    $this->id = $id;

    return $this;
  }

  /**
   * Get the value of quantity
   */
  public function getQuantity()
  {
    return $this->quantity;
  }

  /**
   * Set the value of quantity
   *
   * @return  self
   */
  public function setQuantity($quantity)
  {
    $this->quantity = $quantity;

    return $this;
  }

  /**
   * Get the value of product_id
   */
  public function getProduct_id()
  {
    return $this->product_id;
  }

  /**
   * Set the value of product_id
   *
   * @return  self
   */
  public function setProduct_id($product_id)
  {
    $this->product_id = $product_id;

    return $this;
  }

  /**
   * Get the value of cart_id
   */
  public function getCart_id()
  {
    return $this->cart_id;
  }

  /**
   * Set the value of cart_id
   *
   * @return  self
   */
  public function setCart_id($cart_id)
  {
    $this->cart_id = $cart_id;

    return $this;
  }


 

  /**
   * Get the value of pdo
   */
  public function getPdo()
  {
    $this->pdo = $this->pdo ?? (new Database())->connection();
    return $this->pdo;
  }

  public function __sleep()
  {
    return ['id', 'quantity', 'product_id', 'cart_id'];
  }

  public function __wakeup()
  {
    $this->pdo = null;
  }

  public function addProductToCart($product_id, $quantity): void
  {
    $this->getPdo();
    $query = $this->pdo->prepare("INSERT INTO product_cart (product_id, quantity, cart_id) VALUES (:product_id, :quantity, :cart_id)");
    $query->execute([
      'product_id' => $product_id,
      'quantity' => $quantity,
      'cart_id' => $_SESSION['cart_id']
    ]);
  }

  public function createProductCart(): static
  {
    $this->getPdo();
    $query = $this->pdo->prepare("INSERT INTO product_cart (product_id, quantity, cart_id) VALUES (:product_id, :quantity, :cart_id)");
    $query->execute([
      'product_id' => $this->product_id,
      'quantity' => $this->quantity,
      'cart_id' => $this->cart_id
    ]);
    $this->id = $this->pdo->lastInsertId();
    return $this;
  }

  public function updateProductCart(): static
  {
    $this->getPdo();
    $query = $this->pdo->prepare("UPDATE product_cart SET quantity = :quantity WHERE id = :id");
    $query->execute([
      'quantity' => $this->quantity,
      'id' => $this->id
    ]);
    return $this;
  }
}
