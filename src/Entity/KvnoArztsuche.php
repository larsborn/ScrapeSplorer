<?php declare(strict_types=1);

namespace App\Entity;

use DateTimeImmutable;

class KvnoArztsuche extends ArangoEntity
{
    private int $kvnoId;
    private ?DateTimeImmutable $createdAt;

    public function __construct(string $id, int $kvnoId, ?DateTimeImmutable $createdAt)
    {
        $this->id = $id;
        $this->kvnoId = $kvnoId;
        $this->createdAt = $createdAt;
    }

    public function getkvnoId(): int
    {
        return $this->kvnoId;
    }

    public function getCreatedAt(): ?DateTimeImmutable
    {
        return $this->createdAt;
    }
}
