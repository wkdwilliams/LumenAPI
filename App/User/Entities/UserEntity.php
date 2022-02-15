<?php

namespace App\User\Entities;

use Core\Entity;
use Core\EntityCollection;

class UserEntity extends Entity
{
    /**
     * @var string
     */
    private string $name;

    /**
     * @var string
     */
    private string $email;

    /**
     * @var EntityCollection
     */
    private EntityCollection $messages;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return array
     */
    public function getMessages(): EntityCollection
    {
        return $this->messages;
    }

    public function setMessages(EntityCollection $messages): void
    {
        $this->messages = $messages;
    }



}
