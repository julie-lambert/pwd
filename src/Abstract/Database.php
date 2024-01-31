<?php

namespace App\Abstract;

use PDO;
use PDOException;

class Database
{
  protected ?PDO $pdo = null;
  private string $dbname;
  private string $host;
  private string $dbuser;
  private string $password;

  public function __construct()
  {
    $this->dbname = 'draft-shop';
    $this->host = 'localhost';
    $this->dbuser = 'root';
    $this->password = '';
    $this->connection();
  }

  public function connection()
  {

    try {
      $pdo = new PDO("mysql:host=$this->host;dbname=$this->dbname;charset=utf8", $this->dbuser, $this->password);
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      return $pdo;
    } catch (PDOException $e) {
      echo $e->getMessage();
    }
  }
}
