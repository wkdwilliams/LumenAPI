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
     * @return string
     */
    public function getUserId(): string
    {
        return $this->userId;
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
        
}
