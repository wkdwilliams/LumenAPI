<?php

use App\Image\Models\Image;
use Illuminate\Database\Seeder;

class ImageSeeder extends Seeder
{
    public function run()
    {
        factory(Image::class, 5)->create();
    }
}
