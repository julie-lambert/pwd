<?php

namespace App;

use PDO;
use DateTime;
use App\Abstract\Product;

class Category
{
    private ?PDO $pdo = null;
    public function __construct(private ?int $id = null, private ?string $name = null, private ?string $description = null, private ?DateTime $createdAt = null, private ?DateTime $updatedAt = null)
    {
        // construct here
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
     * Get the value of pdo
     */
    public function getPdo()
    {
        return $this->pdo;
    }

    /**
     * Set the value of pdo
     * @return  self
     */
    public function setPdo($pdo)
    {
        $this->pdo = $pdo;
        return $this;
    }

    ////////////////////////////////////
    //          METHODS               //

    public function getrandomCateg()
    {
        // récupérer les infos d'une catégorie aléatoire (avec l'id allant de 1 à 3)
        $query = $this->pdo->prepare("SELECT * FROM category WHERE id = :id");
        $query->execute([
            "id" => rand(1, 3)
        ]);
        $result = $query->fetch(PDO::FETCH_ASSOC);
        //on set les infos récupérées dans les attributs de l'objet
        $this->setId($result['id']);
        $this->setName($result['name']);
        $this->setDescription($result['description']);
        $this->setCreatedAt(new DateTime($result['createdAt']));
        $this->setUpdatedAt(new DateTime($result['updatedAt']));
    }

    public function getProducts()
    {
        // récupérer les produits de la catégorie
        $query = $this->pdo->prepare("SELECT * FROM product WHERE id_category = :id");
        $query->execute([
            "id" => $this->id
        ]);
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        // var_dump($result);
        //on crée un tableau vide
        $products = [];
        //on boucle sur le résultat de la requête si il y a des résultats
        if (!$result) {
            return $products;
        };
        foreach ($result as $product) {
            //on crée un objet Product
            $product = new Product($product['id'], $product['name'], json_decode($product['photos']), $product['price'], $product['description'], $product['quantity'], new DateTime($product['createdAt']), new DateTime($product['updatedAt']), $product['id_category']);
            //on ajoute l'objet au tableau
            $products[] = $product;
        }
        //on retourne le tableau
        return $products;
    }
}
