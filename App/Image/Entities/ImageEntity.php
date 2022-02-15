<?php

namespace App\Image\Entities;

use Core\Entity;

class ImageEntity extends Entity
{
    /**
     * @var string
     */
    private string $url;

    public function getUrl(): string
    {
        return $this->url;
    }

    public function setUrl(string $url): void
    {
        $this->url = $url;
    }


}
