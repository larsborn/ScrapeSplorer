<?php declare(strict_types=1);

namespace App\Repository;

use App\Arango\AbstractArangoRepository;
use App\Entity\ZvgEntry;
use App\InputHelper;
use ArangoDBClient\Document;

/**
 * @template-extends AbstractArangoRepository<ZvgEntry>
 */
class ZvgEntryRepository extends AbstractArangoRepository
{
    protected function getCollectionName(): string
    {
        return 'zvg_entries';
    }

    protected function constructEntity(Document $document): object
    {
        return new ZvgEntry($document->getId(), InputHelper::string($document->get('zvg_id')));
    }

    /**
     * @return ZvgEntry[]
     */
    public function findByZvgId(string $zvgId): array
    {
        return $this->aql('FOR row IN zvg_entries FILTER row.zvg_id == @zvgId RETURN row', ['zvgId' => $zvgId]);
    }
}
