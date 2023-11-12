<?php declare(strict_types=1);

namespace App\Repository;

use App\Arango\AbstractArangoRepository;
use App\Entity\ZvgEntry;
use App\InputHelper;
use ArangoDBClient\Document;
use DateTimeImmutable;

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
        $adresse = InputHelper::nullableArray($document->get('adresse'));
        $termin = InputHelper::nullableString($document->get('termin_as_date'));

        $insertedAt = InputHelper::nullableString($document->get('inserted_at'));

        return new ZvgEntry(
            $document->getId(),
            InputHelper::nullableInt($document->get('zvg_id')),
            $adresse === null ? null : InputHelper::string($adresse['strasse']),
            $adresse === null ? null : InputHelper::string($adresse['plz']),
            $adresse === null ? null : InputHelper::string($adresse['ort']),
            InputHelper::string($document->get('amtsgericht')),
            InputHelper::nullableString($document->get('grundbuch')),
            InputHelper::nullableString($document->get('objekt_lage')),
            InputHelper::string($document->get('aktenzeichen')),
            $termin === null ? null : new DateTimeImmutable($termin),
            InputHelper::int((int)$document->get('verkehrswert_in_cent')),
            InputHelper::nullableString($document->get('art_der_versteigerung')),
            InputHelper::nullableString($document->get('beschreibung')),
            InputHelper::array($document->get('anhang_sha256s')),
            InputHelper::nullableString($document->get('informationen_zum_glaeubiger')),
            InputHelper::string($document->get('land_short')),
            new DateTimeImmutable(InputHelper::string($document->get('letzte_aktualisierung'))),
            $insertedAt === null ? null : new DateTimeImmutable($insertedAt),
            InputHelper::nullableString($document->get('ort_der_versteigerung')),
            InputHelper::nullableString($document->get('raw_entry_sha256')),
            InputHelper::nullableString($document->get('raw_list_sha256')),
            InputHelper::array($document->get('urls')),
            InputHelper::bool($document->get('wurde_aufgehoben')),
        );
    }

    /**
     * @return ZvgEntry[]
     */
    public function findByZvgId(int $zvgId): array
    {
        return $this->aql(
            strtr(
                <<<AQL
FOR row IN zvg_entries
    FILTER row.zvg_id == @zvgId
    SORT
        row.inserted_at {ordering},
        row.letzte_aktualisierung  {ordering},
        row.termin_as_date {ordering},
        row.key {ordering}
    RETURN row
AQL,
                ['{ordering}' => 'DESC']
            )
            ,
            ['zvgId' => $zvgId]
        );
    }

    public function getNewest(): ?ZvgEntry
    {
        $results = $this->aql(
            <<<AQL
FOR row IN zvg_entries
    SORT row.inserted_at DESC
    LIMIT 1
    RETURN row
AQL
        );

        return count($results) > 0 ? $results[0] : null;
    }

    public function uniqueAktenzeichen(): int
    {
        return $this->oneFromRawAql(
            <<<AQL
FOR row IN zvg_entries
    FILTER row.aktenzeichen != NULL
    COLLECT WITH COUNT INTO cnt
    RETURN cnt
AQL
        );
    }
}
