<?php declare(strict_types=1);

namespace App\Entity;

class ZvgEntry extends ArangoEntity
{
    private string $zvgId;

    public function __construct(string $id, string $zvgId)
    {
        $this->id = $id;
        $this->zvgId = $zvgId;
    }

    public function getZvgId(): string
    {
        return $this->zvgId;
    }
}
