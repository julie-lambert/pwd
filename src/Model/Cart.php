<?php

namespace App\Model;

use App\Abstract\Database;

use PDO;

class Cart
{
  public function __construct(
    private ?int $id = null,
    private ?int $total = null,
    private ?int $user_id = null,
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
   * Get the value of total
   */
  public function getTotal()
  {
    return $this->total;
  }

  /**
   * Set the value of total
   *
   * @return  self
   */
  public function setTotal($total)
  {
    $this->total = $total;

    return $this;
  }

  /**
   * Get the value of user_id
   */
  public function getUser_id()
  {
    return $this->user_id;
  }

  /**
   * Set the value of user_id
   *
   * @return  self
   */
  public function setUser_id($user_id)
  {
    $this->user_id = $user_id;

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
    return ['id', 'total', 'user_id'];
  }

  public function __wakeup()
  {
    $this->pdo = null;
  }

  // On crée un panier
  public function createCart(): static
  {
    $this->getPdo();
    $query = $this->pdo->prepare("INSERT INTO cart (total, user_id) VALUES (:total, :user_id)");
    $query->execute([
      'total' => $this->total,
      'user_id' => $this->user_id
    ]);
    $this->id = $this->pdo->lastInsertId();
    return $this;
  }

  // On récupère un panier par son id utilisateur
  public function findOneByUserId(int $user_id): static|bool
  {
    $this->getPdo();
    $query = $this->pdo->prepare("SELECT * FROM cart WHERE user_id = :user_id");
    $query->execute(['user_id' => $user_id]);
    $cart = $query->fetch(PDO::FETCH_ASSOC);
    if ($cart === false) {
      return false;
    }
    $current_cart = new Cart();
    $current_cart->setId($cart['id']);
    $current_cart->setTotal($cart['total']);
    $current_cart->setUser_id($cart['user_id']);
    return $current_cart;
  }

  // On met à jour le panier
  public function updateCart(): void
  {
    $this->getPdo();
    $query = $this->pdo->prepare("UPDATE cart SET total = :total WHERE id = :id");
    $query->execute([
      'total' => $this->total,
      'id' => $this->id
    ]);
  }

  // On supprime un panier
  public function deleteCart($user_id): bool
  {
    $this->getPdo();
    $query = $this->pdo->prepare("DELETE FROM cart WHERE user_id = :user_id");
    return $query->execute(['user_id' => $user_id]);
  }
}
