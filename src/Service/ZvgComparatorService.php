<?php declare(strict_types=1);

namespace App\Service;

use App\Entity\ZvgEntry;

class ZvgComparatorService
{
    /**
     * @param ZvgEntry[] $rows
     * @return ZvgEntry[]
     */
    public function uniquifySortedList(array $rows): array
    {
        $ret = [$rows[0]];
        foreach (array_slice($rows, 1) as $row) {
            if ($this->isDifferent($ret[count($ret) - 1], $row)) {
                $ret[] = $row;
            }
        }

        return $ret;
    }

    public function isDifferent(ZvgEntry $left, ZvgEntry $right): bool
    {
        if ($left->getZvgId() !== $right->getZvgId()) {
            return false;
        }

        if ($left->getStrasse() !== $right->getStrasse()) {
            return false;
        }

        if ($left->getPlz() !== $right->getPlz()) {
            return false;
        }

        if ($left->getOrt() !== $right->getOrt()) {
            return false;
        }

        if ($left->getAmtsgericht() !== $right->getAmtsgericht()) {
            return false;
        }

        if ($left->getGrundbuch() !== $right->getGrundbuch()) {
            return false;
        }

        if ($left->getObjektLage() !== $right->getObjektLage()) {
            return false;
        }

        if ($left->getAktenzeichen() !== $right->getAktenzeichen()) {
            return false;
        }

        $leftTermin = $left->getTermin();
        $rightTermin = $right->getTermin();
        if ($leftTermin === null) {
            if ($rightTermin !== null) {
                return false;
            }
        } else {
            if ($rightTermin === null) {
                return false;
            } else {
                if ($leftTermin->format('Y-m-d') !== $rightTermin->format('Y-m-d')) {
                    return false;
                }
            }
        }

        if ($left->getVerkehrswertInCent() !== $right->getVerkehrswertInCent()) {
            return false;
        }

        if ($left->getArtDerVersteigerung() !== $right->getArtDerVersteigerung()) {
            return false;
        }

        if ($left->getBeschreibung() !== $right->getBeschreibung()) {
            return false;
        }

        if (count(array_diff($left->getAnhangSha256s(), $right->getAnhangSha256s())) > 0) {
            return false;
        }

        if ($left->getInformationenZumGlaeubiger() !== $right->getInformationenZumGlaeubiger()) {
            return false;
        }

        if ($left->getLandShort() !== $right->getLandShort()) {
            return false;
        }

        if ($left->getLetzteAktualisierung() !== $right->getLetzteAktualisierung()) {
            return false;
        }

        if ($left->getOrtDerVersteigerung() !== $right->getOrtDerVersteigerung()) {
            return false;
        }

        return true;
    }
}
