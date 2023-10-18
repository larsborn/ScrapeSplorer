<?php declare(strict_types=1);

namespace App\Controller;

use App\Repository\ZvgEntryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/zvg')]
class ZvgController extends AbstractController
{
    private ZvgEntryRepository $zvgEntryRepository;

    public function __construct(
        ZvgEntryRepository $zvgEntryRepository,
    ) {
        $this->zvgEntryRepository = $zvgEntryRepository;
    }

    #[Route('/')]
    public function list(Request $request): Response
    {
        $itemsPerPage = 10;
        $page = (int)$request->query->get('page', '0');
        $totalCount = $this->zvgEntryRepository->countAll();

        return $this->render('zvg/list.html.twig', [
            'entries' => $this->zvgEntryRepository->pagination($itemsPerPage, $page * $itemsPerPage),
            'count' => $totalCount,
            'currentPage' => $page,
            'pageCount' => ceil($totalCount / $itemsPerPage),
        ]);
    }
}