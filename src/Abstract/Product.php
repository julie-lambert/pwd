<?php

namespace App\Abstract;

use App\Category;
use PDO;
use PDOException;
use DateTime;

abstract class Product
{

    protected ?PDO $pdo = null;

    public function __construct(
        protected ?int $id = null,
        protected ?string $name = null,
        protected ?array $photos = null,
        protected ?int $price = null,
        protected ?string $description = null,
        protected ?int $quantity = null,
        protected ?DateTime $createdAt = null,
        protected ?DateTime $updatedAt = null,
        protected ?int $id_category = null
    ) {
        // construct here
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
     * Get the value of name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @return  self
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of photos
     */
    public function getPhotos()
    {
        return $this->photos;
    }

    /**
     * Set the value of photos
     *
     * @return  self
     */
    public function setPhotos($photos)
    {
        $this->photos = $photos;

        return $this;
    }

    /**
     * Get the value of price
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set the value of price
     *
     * @return  self
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get the value of description
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set the value of description
     *
     * @return  self
     */
    public function setDescription($description)
    {
        $this->description = $description;

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
     * Get the value of createdAt
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set the value of createdAt
     *
     * @return  self
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get the value of updatedAt
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set the value of updatedAt
     *
     * @return  self
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }


    /**
     * Get the value of id_category
     */
    public function getId_category()
    {
        return $this->id_category;
    }

    /**
     * Set the value of id_category
     *
     * @return  self
     */
    public function setId_category($id_category)
    {
        $this->id_category = $id_category;

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

    ////////////////////////
    // Methods //

    public function getCategory()
    {
        $query = $this->pdo->prepare("SELECT * FROM category WHERE id = :id");
        $query->execute([
            "id" => $this->id_category
        ]);
        $result = $query->fetch(PDO::FETCH_ASSOC);
        $category = new Category($result['id'], $result['name'], $result['description'], new DateTime($result['createdAt']), new DateTime($result['updatedAt']));
        return $category;
    }


    abstract public function findOneById(int $id): Product|bool;

    abstract public function findAll(): array;

    protected function create(): Product|bool
    {
        // vérification qu'on a bien tous les attributs nécessaires
        if (!$this->name || !$this->photos || !$this->price || !$this->description || !$this->quantity || !$this->id_category) {
            return false;
        }
        // insertion dans la bdd
        $query = $this->pdo->prepare("INSERT INTO product (name, photos, price, description, quantity, createdAt, updatedAt, id_category) VALUES (:name, :photos, :price, :description, :quantity, :createdAt, :updatedAt, :id_category)");
        $query->execute([
            "name" => $this->name,
            "photos" => json_encode($this->photos),
            "price" => $this->price,
            "description" => $this->description,
            "quantity" => $this->quantity,
            "createdAt" => $this->createdAt->format('Y-m-d H:i:s'),
            "updatedAt" => $this->updatedAt->format('Y-m-d H:i:s'),
            "id_category" => $this->id_category
        ]);
        // Si la requête a fonctionné, on récupère l'id généré
        if ($query->rowCount() > 0) {
            $this->id = $this->pdo->lastInsertId();
            return $this;
        } else {
            return false;
        }
    }

    protected function update(): Product|bool
    {
        // vérification qu'on a bien tous les attributs nécessaires
        if (!$this->id || !$this->name || !$this->photos || !$this->price || !$this->description || !$this->quantity || !$this->id_category) {
            return false;
        }
        // insertion dans la bdd
        $query = $this->pdo->prepare("UPDATE product SET name = :name, photos = :photos, price = :price, description = :description, quantity = :quantity, createdAt = :createdAt, updatedAt = :updatedAt, id_category = :id_category WHERE id = :id");
        $query->execute([
            "id" => $this->id,
            "name" => $this->name,
            "photos" => json_encode($this->photos),
            "price" => $this->price,
            "description" => $this->description,
            "quantity" => $this->quantity,
            "createdAt" => $this->createdAt->format('Y-m-d H:i:s'),
            "updatedAt" => $this->updatedAt->format('Y-m-d H:i:s'),
            "id_category" => $this->id_category
        ]);
        // Si la requête a fonctionné, on récupère l'id généré
        if ($query) {
            return $this;
        } else {
            return false;
        }
    }
}
