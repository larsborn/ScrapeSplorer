<?php declare(strict_types=1);

namespace App\Repository;

use App\Arango\AbstractArangoRepository;
use App\Entity\KvnoArztsuche;
use App\InputHelper;
use ArangoDBClient\Document;
use DateTimeImmutable;


/**
 * @template-extends AbstractArangoRepository<KvnoArztsuche>
 */
class KvnoArztsucheRepository extends AbstractArangoRepository
{
    protected function getCollectionName(): string
    {
        return 'kvno_arztsuche';
    }

    protected function constructEntity(Document $document): object
    {
        return new KvnoArztsuche(
            $document->getId(),
            InputHelper::int($document->get('id')),
            new DateTimeImmutable($document->get('created_at')),
        );
    }

    /**
     * @return KvnoArztsuche[]
     */
    public function findByKvnoId(int $kvnoId): array
    {
        return $this->aql('FOR row IN kvno_arztsuche FILTER row.id == @kvnoId RETURN row', ['kvnoId' => $kvnoId]);
    }

    public function getNewest(): ?KvnoArztsuche
    {
        $results = $this->aql(
            <<<AQL
FOR row IN kvno_arztsuche
    SORT row.created_at DESC
    LIMIT 1
    RETURN row
AQL
        );

        return count($results) > 0 ? $results[0] : null;
    }
}
