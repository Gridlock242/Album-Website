<?php

namespace App\Controller;

use App\Repository\GenreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class IndexController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(GenreRepository $genreRepository, int $page = 1): Response
    {
        $genres = $genreRepository->findBy([], ['name' => 'ASC']);

        return $this->render('index/index.html.twig', [
            'page' => $page,
            'genres' => $genres,
        ]);
    }
}

 