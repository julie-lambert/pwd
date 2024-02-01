<?php

namespace App\Model;
use App\Abstract\AbstractProduct;
use App\Abstract\Database;
use PDO;

class Product extends AbstractProduct
{
    public function __construct(
        protected ?int $id = null,
        protected ?string $name = null,
        protected ?array $photos = null,
        protected ?int $price = null,
        protected ?string $description = null,
        protected ?int $quantity = null,
        protected ?\DateTime $createdAt = null,
        protected ?\DateTime $updatedAt = null,
        protected ?int $category_id = null,
        protected ?\PDO $pdo = null,

    ) {
        parent::__construct($id, $name, $photos, $price, $description, $quantity, $createdAt, $updatedAt, $category_id, $pdo);
    }

    public function getPdo(){
        $this->pdo = $this->pdo ?? (new Database())->connection();
        return $this->pdo;
    }

    public function sleep(){
       return[
           'id',
           'name' ,
           'photos' ,
           'price',
           'description',
           'quantity',
           'createdAt',
           'updatedAt' ,
           'category_id',
       ];
    }

    public function wakeUp(){
        $this->pdo = null;
    
    }

    public function findPaginated(int $page): array
    {
        $pdo = $this->getPdo();
        $offset = ($page - 1) * 10;
        $query = $pdo->prepare('SELECT * FROM product LIMIT 10 OFFSET :offset');
        $query->bindValue(':offset', $offset, PDO::PARAM_INT);
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_ASSOC);

        $products = [];
        foreach ($results as $result) {
            $product = new Product();
            $product->setId($result['id']);
            $product->setName($result['name']);
            $product->setPhotos(json_decode($result['photos']));
            $product->setPrice($result['price']);
            $product->setDescription($result['description']);
            $product->setQuantity($result['quantity']);
            $product->setCreatedAt(new \DateTime($result['createdAt']));
            $product->setUpdatedAt(new \DateTime($result['updatedAt']));
            $product->setCategory_id($result['category_id']);
            $products[] = $product;
        }
        return $products;
    }

    public function findOneById(int $id): Product|bool
    {
        $pdo = $this->getPdo();
        $query = $pdo->prepare("SELECT * FROM product WHERE id = :id");
        $query->execute([
            "id" => $id
        ]);
        $result = $query->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            $product = new Product(
                $result['id'],
                $result['name'],
                json_decode($result['photos']),
                $result['price'],
                $result['description'],
                $result['quantity'],
                new \DateTime($result['createdAt']),
                new \DateTime($result['updatedAt']),
                $result['category_id'],
            );
            return $product;
        } else {
            return false;
        }
    }

}