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
     * @var Entity
     */
    private Entity $category;

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
