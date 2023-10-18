<?php declare(strict_types=1);

namespace App\Twig;

use App\Service\PathUtilsService;
use App\Table\ColumnType\EuroType;
use DateTimeImmutable;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Uid\Uuid;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;
use Twig\TwigTest;

class AppExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('centsAsEuro', [$this, 'centsAsEuro']),
            new TwigFilter('dateAllowEmpty', [$this, 'dateAllowEmpty']),
        ];
    }

    public function dateAllowEmpty(?DateTimeImmutable $data): string
    {
        if ($data === null) {
            return '';
        }

        return $data->format('d.m.Y');
    }

    public function centsAsEuro(?int $number): string
    {
        if (!$number) {
            return '';
        }

        return number_format($number / 100, 2, '.', '') . ' €';
    }

}
