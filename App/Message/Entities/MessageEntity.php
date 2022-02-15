<?php

namespace App\Message\Entities;

use Core\Entity;
use Core\EntityCollection;

class MessageEntity extends Entity
{
    /**
     * @var string
     */
    private string $message;

    /**
     * @var EntityCollection
    */
    private EntityCollection $images;

    public function getMessage(): string
    {
        return $this->message;
    }

    public function setMessage(string $message): void
    {
        $this->message = $message;
    }

    public function getImages(): EntityCollection
    {
        return $this->images;
    }

    public function setImages(EntityCollection $images): void
    {
        $this->images = $images;
    }


}
