<?php

namespace App\Product\Models;

use App\Category\Models\Category;
use Core\Model;

class Product extends Model
{
    protected $table = "products";
    
    protected $appends = [
            'category'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function getCategoryAttribute()
    {
        return $this->category()->get();
    }

}
