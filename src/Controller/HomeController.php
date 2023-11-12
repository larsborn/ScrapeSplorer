<?php declare(strict_types=1);

namespace App\Controller;

use App\Repository\KvnoArztsucheRepository;
use App\Repository\ZvgEntryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/')]
class HomeController extends AbstractController
{
    private ZvgEntryRepository $zvgEntryRepository;
    private KvnoArztsucheRepository $kvnoArztsucheRepository;

    public function __construct(
        ZvgEntryRepository $zvgEntryRepository,
        KvnoArztsucheRepository $kvnoArztsucheRepository,
    ) {
        $this->zvgEntryRepository = $zvgEntryRepository;
        $this->kvnoArztsucheRepository = $kvnoArztsucheRepository;
    }

    #[Route('/')]
    public function home(): Response
    {
        $zvgEntry = $this->zvgEntryRepository->getNewest();
        $kvnoArztsuche = $this->kvnoArztsucheRepository->getNewest();

        return $this->render('home/home.html.twig', [
            'zvg_entries_count' => $this->zvgEntryRepository->countAll(),
            'zvg_aktenzeichen_count' => $this->zvgEntryRepository->uniqueAktenzeichen(),
            'zvg_entries_newest_timestamp' => $zvgEntry->getInsertedAt(),
            'zvg_entries_newest_key' => $zvgEntry->getKey(),
            'kvno_arztsuche_count' => $this->kvnoArztsucheRepository->countAll(),
            'kvno_arztsuche_newest_timestamp' => $kvnoArztsuche->getCreatedAt(),
            'kvno_arztsuche_newest_key' => $kvnoArztsuche->getKey(),
        ]);
    }
}
