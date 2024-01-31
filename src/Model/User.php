<?php

namespace App\Model;

use PDO;
use PDOException;
use DateTime;

class User
{
  protected ?PDO $pdo = null;
  public function __construct(
    private ?int $id = null,
    private ?string $fullname = null,
    private ?string $email = null,
    private ?string $password = null,
    private ?array $role = []

  ) {

    // connect to database pdo
    $dbname = 'draft-shop';
    $host = 'localhost';
    $dbuser = 'root';
    $password = '';

    try {
      $this->pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $dbuser, $password);
    } catch (PDOException $e) {
      echo $e->getMessage();
    }
  }

  // Getters and Setters //
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
   * Get the value of fullname
   */
  public function getFullname()
  {
    return $this->fullname;
  }
  /**
   * Set the value of fullname
   *
   * @return  self
   */
  public function setFullname($fullname)
  {
    $this->fullname = $fullname;
    return $this;
  }
  /**
   * Get the value of email
   */
  public function getEmail()
  {
    return $this->email;
  }
  /**
   * Set the value of email
   *
   * @return  self
   */
  public function setEmail($email)
  {
    $this->email = $email;
    return $this;
  }
  /**
   * Get the value of password
   */
  public function getPassword()
  {
    return $this->password;
  }
  /**
   * Set the value of password
   *
   * @return  self
   */
  public function setPassword($password)
  {
    $this->password = $password;
    return $this;
  }
  /**
   * Get the value of role
   */
  public function getRole(): array
  {
    return $this->role;
  }
  /**
   * Set the value of role
   *
   * @return  self
   */
  public function setRole($role)
  {
    $this->role = $role;
    return $this;
  }
  /**
   * Get the value of pdo
   */
  public function getPdo()
  {
    return $this->pdo;
  }
  /**
   * Set the value of pdo
   *
   * @return  self
   */
  public function setPdo($pdo)
  {
    $this->pdo = $pdo;
    return $this;
  }

  // Methods //
  public function findOneById(int $id): ?User
  {
    $sql = "SELECT * FROM user WHERE id = :id";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute(['id' => $id]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($result === false) {
      return null;
    } else {
      $user = new User();
      $user->setId($result['id']);
      $user->setFullname($result['fullname']);
      $user->setEmail($result['email']);
      $user->setPassword($result['password']);
      $user->setRole($result['role']);
      return $user;
    }
  }

  public function findAll(): array
  {
    $sql = "SELECT * FROM user";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $users = [];
    foreach ($result as $row) {
      $user = new User();
      $user->setId($row['id']);
      $user->setFullname($row['fullname']);
      $user->setEmail($row['email']);
      $user->setRole($row['role']);
      $users[] = $user;
    }
    return $users;
  }

  //REGISTER FUNCTION
  public function create(): User|bool
  {
    $sql = "INSERT INTO user (fullname, email, password, role) VALUES (:fullname, :email, :password, :role)";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([
      'fullname' => $this->fullname,
      'email' => $this->email,
      'password' => $this->password,
      'role' => json_encode($this->role)
    ]);
    $count = $stmt->rowCount();
    if ($count > 0) {
      return true;
    } else {
      return false;
    }
  }

  //UPDATE FUNCTION
  public function update(): User|bool
  {
    $sql = "UPDATE user SET fullname = :fullname, email = :email, password = :password, role = :role WHERE id = :id";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([
      'fullname' => $this->fullname,
      'email' => $this->email,
      'password' => $this->password,
      'role' => $this->role,
      'id' => $this->id
    ]);
    $count = $stmt->rowCount();
    if ($count > 0) {
      return true;
    } else {
      return false;
    }
  }

  public function findOneByEmail($email): User|false
  {
    $sql = "SELECT * FROM user WHERE email = :email";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute(['email' => $email]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($result === false) {
      return $result;
    } else {
      $user = new User();
      $user->setId($result['id']);
      $user->setFullname($result['fullname']);
      $user->setEmail($result['email']);
      $user->setPassword($result['password']);
      $user->setRole($result['role']);
      return $user;
    }
  }
}
