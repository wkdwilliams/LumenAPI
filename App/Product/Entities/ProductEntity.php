<?php

namespace App\Product\Entities;
    
use Core\Entity;

class ProductEntity extends Entity
{

    /**
     * @var string
     */
    private string $name;

    /**
     * @var int
     */
    private int $userId;

    /**
     * @var int
     */
    private int $categoryId;

    /**
     * @var Entity
     */
    private Entity $category;

    /**
     * @return string
     */
    public function getCategoryId(): string
    {
        return $this->categoryId;
    }

    /**
     * @param string $name
     * 
     * @return void
     */
    public function setCategoryId(string $categoryId): void
    {
        $this->categoryId = $categoryId;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * 
     * @return void
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @param string $name
     * 
     * @return void
     */
    public function setUserId(string $userId): void
    {
        $this->userId = $userId;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @return Entity
     */
    public function getCategory(): Entity
    {
        return $this->category;
    }

    /**
     * @param string $name
     * 
     * @return void
     */
    public function setCategory(Entity $category): void
    {
        $this->category = $category;
    }
}
