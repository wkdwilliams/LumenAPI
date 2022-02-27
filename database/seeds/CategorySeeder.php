<?php

use App\Category\Models\Category;
use Illuminate\Database\Seeder;
    
class CategorySeeder extends Seeder
{
    public function run()
    {
        factory(Category::class, 20)->create();
    }
}
