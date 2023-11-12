<?php declare(strict_types=1);

namespace App\Twig;

use DateTimeImmutable;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class AppExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('centsAsEuro', [$this, 'centsAsEuro']),
            new TwigFilter('dateAllowEmpty', [$this, 'dateAllowEmpty']),
            new TwigFilter('datetimeAllowEmpty', [$this, 'datetimeAllowEmpty']),
        ];
    }

    public function dateAllowEmpty(?DateTimeImmutable $data): string
    {
        return $this->emptyFormat('Y-m-d', $data);
    }

    public function datetimeAllowEmpty(?DateTimeImmutable $data): string
    {
        return $this->emptyFormat('Y-m-d H:i:s', $data);
    }

    private function emptyFormat(string $format, ?DateTimeImmutable $data): string
    {
        if ($data === null) {
            return '';
        }

        return $data->format($format);
    }

    public function centsAsEuro(?int $number): string
    {
        if (! $number) {
            return '';
        }

        return number_format($number / 100, 2, '.', '') . ' €';
    }

}
