<?php declare(strict_types=1);

namespace App\Entity;

use DateTimeImmutable;

class ZvgEntry extends ArangoEntity
{
    private ?int $zvgId;
    private ?string $strasse;
    private ?string $plz;
    private ?string $ort;
    private string $amtsgericht;
    private ?string $grundbuch;
    private ?string $objektLage;
    private string $aktenzeichen;
    private ?DateTimeImmutable $termin;
    private ?int $verkehrswertInCent;
    private ?string $artDerVersteigerung;
    private ?string $beschreibung;
    /** @var string[] */
    private array $anhangSha256s;
    private ?string $informationenZumGlaeubiger;
    private string $landShort;
    private DateTimeImmutable $letzteAktualisierung;
    private ?DateTimeImmutable $insertedAt;
    private ?string $ortDerVersteigerung;
    private ?string $rawEntrySha256;
    private ?string $rawListSha256;
    /** @var string[] */
    private array $urls;
    private bool $wurdeAufgehoben;

    public function __construct(
        string $id,
        ?int $zvgId,
        ?string $strasse,
        ?string $plz,
        ?string $ort,
        string $amtsgericht,
        ?string $grundbuch,
        ?string $objektLage,
        string $aktenzeichen,
        ?DateTimeImmutable $termin,
        ?int $verkehrswertInCent,
        ?string $artDerVersteigerung,
        ?string $beschreibung,
        array $anhangSha256s,
        ?string $informationenZumGlaeubiger,
        string $landShort,
        DateTimeImmutable $letzteAktualisierung,
        ?DateTimeImmutable $insertedAt,
        ?string $ortDerVersteigerung,
        ?string $rawEntrySha256,
        ?string $rawListSha256,
        array $urls,
        bool $wurdeAufgehoben,
    ) {
        $this->id = $id;
        $this->zvgId = $zvgId;
        $this->strasse = $strasse;
        $this->plz = $plz;
        $this->ort = $ort;
        $this->amtsgericht = $amtsgericht;
        $this->grundbuch = $grundbuch;
        $this->objektLage = $objektLage;
        $this->aktenzeichen = $aktenzeichen;
        $this->termin = $termin;
        $this->verkehrswertInCent = $verkehrswertInCent;
        $this->artDerVersteigerung = $artDerVersteigerung;
        $this->beschreibung = $beschreibung;
        $this->anhangSha256s = $anhangSha256s;
        $this->informationenZumGlaeubiger = $informationenZumGlaeubiger;
        $this->landShort = $landShort;
        $this->letzteAktualisierung = $letzteAktualisierung;
        $this->insertedAt = $insertedAt;
        $this->ortDerVersteigerung = $ortDerVersteigerung;
        $this->rawEntrySha256 = $rawEntrySha256;
        $this->rawListSha256 = $rawListSha256;
        $this->urls = $urls;
        $this->wurdeAufgehoben = $wurdeAufgehoben;
    }

    public function getZvgId(): ?int
    {
        return $this->zvgId;
    }

    public function getStrasse(): ?string
    {
        return $this->strasse;
    }

    public function getPlz(): ?string
    {
        return $this->plz;
    }

    public function getOrt(): ?string
    {
        return $this->ort;
    }

    public function getGrundbuch(): ?string
    {
        return $this->grundbuch;
    }

    public function getObjektLage(): ?string
    {
        return $this->objektLage;
    }

    public function getAktenzeichen(): string
    {
        return $this->aktenzeichen;
    }

    public function getTermin(): ?DateTimeImmutable
    {
        return $this->termin;
    }

    public function getVerkehrswertInCent(): ?int
    {
        return $this->verkehrswertInCent;
    }

    public function getArtDerVersteigerung(): ?string
    {
        return $this->artDerVersteigerung;
    }

    public function getBeschreibung(): ?string
    {
        return $this->beschreibung;
    }

    public function getAmtsgericht(): string
    {
        return $this->amtsgericht;
    }

    public function getAnhangSha256s(): array
    {
        return $this->anhangSha256s;
    }

    public function getInformationenZumGlaeubiger(): ?string
    {
        return $this->informationenZumGlaeubiger;
    }

    public function getLandShort(): string
    {
        return $this->landShort;
    }

    public function getLetzteAktualisierung(): DateTimeImmutable
    {
        return $this->letzteAktualisierung;
    }

    public function getInsertedAt(): ?DateTimeImmutable
    {
        return $this->insertedAt;
    }

    public function getOrtDerVersteigerung(): ?string
    {
        return $this->ortDerVersteigerung;
    }

    public function getRawEntrySha256(): ?string
    {
        return $this->rawEntrySha256;
    }

    public function getRawListSha256(): ?string
    {
        return $this->rawListSha256;
    }

    public function getUrls(): array
    {
        return $this->urls;
    }

    public function isWurdeAufgehoben(): bool
    {
        return $this->wurdeAufgehoben;
    }
}
