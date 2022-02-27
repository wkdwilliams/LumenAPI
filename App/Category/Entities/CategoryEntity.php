<?php

namespace App\Category\Entities;
    
use Core\Entity;
    
class CategoryEntity extends Entity
{
    protected $name;

    public function getName()
    {
        return $this->name;
    }

    public function setName(string $name)
    {
        $this->name = $name;
    }
}
