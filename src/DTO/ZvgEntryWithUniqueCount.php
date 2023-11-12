<?php declare(strict_types=1);

namespace App\DTO;

use App\Entity\ZvgEntry;

final class ZvgEntryWithUniqueCount
{
    /**
     * @var mixed
     */
    public $entry;

    /**
     * @var mixed
     */
    public $uniqueCountByAktenzeichen;

    public function __construct(ZvgEntry $entry, int $uniqueCountByAktenzeichen)
    {
        $this->entry = $entry;
        $this->uniqueCountByAktenzeichen = $uniqueCountByAktenzeichen;
    }
}
