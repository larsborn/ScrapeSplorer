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
        return $this->aql('FOR row IN zvg_entries FILTER row.zvg_id == @zvgId RETURN row', ['zvgId' => $zvgId]);
    }
}
