<?php

namespace App\Controller;

use App\Entity\Album;
use App\Entity\Rating;
use App\Form\RatingType;
use App\Repository\AlbumRepository;
use App\Repository\GenreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class IndexController extends AbstractController
{
    #[Route('/', name: 'app_index')]
    public function index(
        Request $request,
        GenreRepository $genreRepository,
        AlbumRepository $albumRepository,
        EntityManagerInterface $em,
        int $page = 1
    ): Response {
        $genres = $genreRepository->findBy([], ['name' => 'ASC']);
        $user = $this->getUser();

        $query = $request->query->get('q');
        $year = $request->query->get('year');
        $genreId = $request->query->get('genre');

        $albums = $albumRepository->findFilteredAlbums($query, $genreId, $year); // Utilise ta méthode existante
        $ratingsForms = [];

        if ($user) {
            foreach ($albums as $album) {
                $existingRating = $em->getRepository(Rating::class)->findOneBy([
                    'user' => $user,
                    'album' => $album,
                ]);

                $rating = $existingRating ?: new Rating();
                $rating->setUser($user);
                $rating->setAlbum($album);

                $form = $this->createForm(RatingType::class, $rating, [
                    'action' => $this->generateUrl('album_rate', ['id' => $album->getId()])
                ]);

                $ratingsForms[$album->getId()] = $form->createView();
            }
        }

        return $this->render('index/index.html.twig', [
            'page' => $page,
            'genres' => $genres,
            'albums' => $albums,
            'ratingsForms' => $ratingsForms,
        ]);
    }

    #[Route('/album/{id}/rate', name: 'album_rate', methods: ['POST'])]
    public function rate(Request $request, Album $album, EntityManagerInterface $em): Response
    {
        $user = $this->getUser();

        $existing = $em->getRepository(Rating::class)->findOneBy([
            'user' => $user,
            'album' => $album,
        ]);

        if ($existing) {
            $form = $this->createForm(RatingType::class, $existing);
        } else {
            $rating = new Rating();
            $rating->setUser($user);
            $rating->setAlbum($album);
            $form = $this->createForm(RatingType::class, $rating);
        }

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($form->getData());
            $em->flush();
        }
        return $this->redirectToRoute('app_index');
    }
}
