<?php declare(strict_types=1);

namespace App\Repository;

use App\Arango\AbstractArangoRepository;
use App\Entity\KvnoArztsuche;
use App\InputHelper;
use ArangoDBClient\Document;

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
        return new KvnoArztsuche($document->getId(), InputHelper::int($document->get('id')));
    }

    /**
     * @return KvnoArztsuche[]
     */
    public function findByKvnoId(int $kvnoId): array
    {
        return $this->aql('FOR row IN kvno_arztsuche FILTER row.id == @kvnoId RETURN row', ['kvnoId' => $kvnoId]);
    }
}
