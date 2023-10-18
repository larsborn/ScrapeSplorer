<?php declare(strict_types=1);

namespace App\Controller;

use App\Repository\ZvgEntryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/')]
class HomeController extends AbstractController
{
    private ZvgEntryRepository $zvgEntryRepository;

    public function __construct(ZvgEntryRepository $zvgEntryRepository)
    {
        $this->zvgEntryRepository = $zvgEntryRepository;
    }

    #[Route('/')]
    public function home(): Response
    {
        return $this->render('home/home.html.twig', [
            'zvg_entries_count' => $this->zvgEntryRepository->countAll(),
        ]);
    }
}
