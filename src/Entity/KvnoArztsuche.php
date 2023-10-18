<?php declare(strict_types=1);

namespace App\Entity;

class KvnoArztsuche extends ArangoEntity
{
    private int $kvnoId;

    public function __construct(string $id, int $kvnoId)
    {
        $this->id = $id;
        $this->kvnoId = $kvnoId;
    }

    public function getZvgId(): int
    {
        return $this->kvnoId;
    }
}
