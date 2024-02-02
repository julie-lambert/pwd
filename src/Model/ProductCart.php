<?php

namespace App\Model;

use DateTime;
use PDO;
use App\Abstract\Database;

class ProductCart
{
  public function __construct(
    private ?int $id = null,
    private ?int $quantity = null,
    private ?int $product_id = null,
    private ?int $cart_id = null,
    private ?DateTime $created_at = null,
    private ?DateTime $updated_at = null,
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
   * Get the value of created_at
   */
  public function getCreated_at()
  {
    return $this->created_at;
  }

  /**
   * Set the value of created_at
   *
   * @return  self
   */
  public function setCreated_at($created_at)
  {
    $this->created_at = $created_at;

    return $this;
  }

  /**
   * Get the value of updated_at
   */
  public function getUpdated_at()
  {
    return $this->updated_at;
  }

  /**
   * Set the value of updated_at
   *
   * @return  self
   */
  public function setUpdated_at($updated_at)
  {
    $this->updated_at = $updated_at;

    return $this;
  }

  /**
   * Get the value of pdo
   */
  public function getPdo()
  {
    $this->pdo = $this->pdo ?? (new Database())->connection();
  }

  public function __sleep()
  {
    return ['id', 'quantity', 'product_id', 'cart_id', 'created_at', 'updated_at'];
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
    $query = $this->pdo->prepare("INSERT INTO product_cart (product_id, quantity, cart_id, created_at) VALUES (:product_id, :quantity, :cart_id, NOW())");
    $query->execute([
      'product_id' => $this->product_id,
      'quantity' => $this->quantity,
      'cart_id' => $this->cart_id
    ]);
    $this->id = $this->pdo->lastInsertId();
    return $this;
  }
}
