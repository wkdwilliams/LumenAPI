<?php

namespace App\Message\Entities;

use Core\Entity;

class MessageEntity extends Entity
{
    /**
     * @var string
     */
    private string $message;

    public function getMessage(): string
    {
        return $this->message;
    }

    public function setMessage(string $message): void
    {
        $this->message = $message;
    }


}
