<?php

namespace App;

use App\Abstract\Product;
use App\Interface\SockableInterface;
use PDO;
use DateTime;


class Electronic extends Product implements SockableInterface
{
    protected ?PDO $pdo;

    // size, color, type, material_fee
    public function __construct(
        protected ?int $id = null,
        protected ?string $name = null,
        protected ?array $photos = null,
        protected ?int $price = null,
        protected ?string $description = null,
        protected ?int $quantity = null,
        protected ?DateTime $createdAt = null,
        protected ?DateTime $updatedAt = null,
        protected ?int $id_category = null,
        protected ?string $brand = null,
        protected ?int $waranty_fee = null
    ) {
        parent::__construct($id, $name, $photos, $price, $description, $quantity, $createdAt, $updatedAt, $id_category);
    }

    /**
     * Get the value of brand
     */
    public function getBrand()
    {
        return $this->brand;
    }

    /**
     * Set the value of brand
     *
     * @return  self
     */
    public function setBrand($brand)
    {
        $this->brand = $brand;

        return $this;
    }

    /**
     * Get the value of waranty_fee
     */
    public function getWaranty_fee()
    {
        return $this->waranty_fee;
    }

    /**
     * Set the value of waranty_fee
     *
     * @return  self
     */
    public function setWaranty_fee($waranty_fee)
    {
        $this->waranty_fee = $waranty_fee;

        return $this;
    }

    // ///////////////////////
    // methods

    public function findOneById(int $id): Electronic|bool
    {
        $query = $this->pdo->prepare(
            "SELECT * FROM electronic INNER JOIN product ON electronic.id_product = product.id WHERE id_product = :id"
        );
        $query->execute([
            "id" => $id
        ]);
        $result = $query->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            $electronic = new Electronic(
                $result['id'],
                $result['name'],
                json_decode($result['photos']),
                $result['price'],
                $result['description'],
                $result['quantity'],
                new DateTime($result['createdAt']),
                new DateTime($result['updatedAt']),
                $result['id_category'],
                $result['brand'],
                $result['waranty_fee']
            );
            return $electronic;
        } else {
            return false;
        }
    }

    public function findAll(): array
    {
        $query = $this->pdo->prepare(
            "SELECT * FROM electronic INNER JOIN product ON electronic.id_product = product.id"
        );
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_ASSOC);
        $electronics = [];
        foreach ($results as $electronic) {

            $electronics[] = new Electronic(
                $electronic['id'],
                $electronic['name'],
                json_decode($electronic['photos']),
                $electronic['price'],
                $electronic['description'],
                $electronic['quantity'],
                new DateTime($electronic['createdAt']),
                new DateTime($electronic['updatedAt']),
                $electronic['id_category'],
                $electronic['brand'],
                $electronic['waranty_fee']
            );
        }
        return $electronics;
    }

    public function create(): Electronic|bool
    {
        $result = parent::create();
        if (!$result) {
            return $result;
        }

        $request = $this->pdo->prepare(
            "INSERT INTO electronic (brand, waranty_fee, id_product) VALUES (:brand, :waranty_fee, :id_product)"
        );
        $result2 = $request->execute(
            [
                'brand' => $this->brand,
                'waranty_fee' => $this->waranty_fee,
                'id_product' => $this->id,
            ]
        );
        if ($result2) {
            return $this;
        } else {
            return $result2;
        }
    }

    public function update(): Electronic|bool
    {
        $result = parent::update();
        if (!$result) {
            return $result;
        }

        $query = $this->pdo->prepare(
            "UPDATE electronic SET brand = :brand, waranty_fee=:waranty_fee WHERE id_product = :id_product"
        );

        $result2 = $query->execute([
            'brand' => $this->brand,
            'waranty_fee' => $this->waranty_fee,
            'id_product' => $this->id,
        ]);

        if ($result2) {
            return $this;
        } else {
            return $result2;
        }
    }

    public function addStocks(int $stock): self
    {
        $this->quantity += $stock;
        // update
        $this->update();
        return $this;
    }

    public function removeStocks(int $stock): self
    {
        $this->quantity -= $stock;
        // update
        $this->update();
        return $this;
    }
}
