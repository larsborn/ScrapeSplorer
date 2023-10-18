<?php declare(strict_types=1);

namespace App\Entity;

abstract class ArangoEntity
{
    protected string $id;

    public function getId(): string
    {
        return $this->id;
    }
    public function getKey(): string
    {
        return explode('/', $this->id)[1];
    }
}
