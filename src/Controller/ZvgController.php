<?php declare(strict_types=1);

namespace App\Controller;

use App\DTO\ZvgEntryWithUniqueCount;
use App\Entity\ZvgEntry;
use App\Repository\ZvgEntryRepository;
use App\Service\ZvgComparatorService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/zvg')]
class ZvgController extends AbstractController
{
    private ZvgEntryRepository $zvgEntryRepository;
    private ZvgComparatorService $zvgComparatorService;

    public function __construct(
        ZvgEntryRepository $zvgEntryRepository,
        ZvgComparatorService $zvgComparatorService,
    ) {
        $this->zvgEntryRepository = $zvgEntryRepository;
        $this->zvgComparatorService = $zvgComparatorService;
    }

    #[Route('/')]
    public function list(Request $request): Response
    {
        $itemsPerPage = 10;
        $page = (int)$request->query->get('page', '0');
        $totalCount = $this->zvgEntryRepository->countAll();

        $entries = array_map(
            fn (ZvgEntry $entry) => new ZvgEntryWithUniqueCount(
                $entry,
                count(
                    $this->zvgComparatorService->uniquifySortedList(
                        $this->zvgEntryRepository->findByAktenzeichen($entry->getAktenzeichen())
                    )
                )
            ),
            $this->zvgEntryRepository->pagination($itemsPerPage, $page * $itemsPerPage),
        );

        return $this->render('zvg/list.html.twig', [
            'entriesWithCounts' => $entries,
            'count' => $totalCount,
            'currentPage' => $page,
            'pageCount' => ceil($totalCount / $itemsPerPage),
        ]);
    }

    #[Route('/entry/{key}')]
    public function showEntry(string $key): Response
    {
        $zvgEntry = $this->zvgEntryRepository->get($key);

        return $this->render('zvg/show-entry.html.twig', ['entry' => $zvgEntry]);
    }

    #[Route('/history')]
    public function show(Request $request): Response
    {
        $aktenzeichen = $request->query->get('aktenzeichen');
        $zvgEntries = $this->zvgComparatorService->uniquifySortedList(
            $this->zvgEntryRepository->findByAktenzeichen($aktenzeichen, true)
        );

        return $this->render('zvg/show.html.twig', ['aktenzeichen' => $aktenzeichen, 'entries' => $zvgEntries]);
    }

    #[Route('/zvg/{zvgId}/{leftKey}/{rightKey}')]
    public function diff(int $zvgId, string $leftKey, string $rightKey): Response
    {
        $left = $this->zvgEntryRepository->get($leftKey);
        $right = $this->zvgEntryRepository->get($rightKey);
        $fieldNames = [
            'strasse',
            'plz',
            'ort',
            'amtsgericht',
            'grundbuch',
            'objektLage',
            'aktenzeichen',
            'verkehrswertInCent',
            'artDerVersteigerung',
            'beschreibung',
            'informationenZumGlaeubiger',
            'landShort',
            'ortDerVersteigerung',
            'rawEntrySha256',
            'rawListSha256',
        ];

        return $this->render(
            'zvg/diff.html.twig',
            ['zvgId' => $zvgId, 'left' => $left, 'right' => $right, 'fieldNames' => $fieldNames]
        );
    }
}
