<?php

namespace App\Controller;

use App\Entity\Album;
use App\Form\AlbumType;
use App\Repository\AlbumRepository;
use App\Repository\GenreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AdminAlbumController extends AbstractController
{
    #[Route('/admin/album', name: 'app_admin_album')]
    public function index(Request $request, EntityManagerInterface $entityManager, AlbumRepository $albumRepository, GenreRepository $genreRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $genres = $genreRepository->findAll();
        $albums = $albumRepository->findAll();

        $album = new Album();
        $form = $this->createForm(AlbumType::class, $album);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($album);
            $entityManager->flush();
            $this->addFlash('success', 'Album ajouté avec succès !');

            return $this->redirectToRoute('app_admin_album');
        }

        return $this->render('admin_album/index.html.twig', [
            'albums' => $albums,
            'genres' => $genres,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/admin/album/delete/{id}', name: 'admin_album_delete', methods: ['POST'])]
    public function delete(Request $request, $id, EntityManagerInterface $entityManager, AlbumRepository $albumRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $album = $albumRepository->find($id);

        if (!$album) {
            throw $this->createNotFoundException('Album non trouvé');
        }

        $entityManager->remove($album);
        $entityManager->flush();

        $this->addFlash('success', 'Album supprimé avec succès !');
        return $this->redirectToRoute('app_admin_album');
    }

    #[Route('/admin/album/edit/{id}', name: 'admin_album_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Album $album, EntityManagerInterface $entityManager, GenreRepository $genreRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $genres = $genreRepository->findAll();

        $form = $this->createForm(AlbumType::class, $album);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $this->addFlash('success', 'Album modifié avec succès !');
            return $this->redirectToRoute('app_admin_album');
        }

        return $this->render('admin_album/edit.html.twig', [
            'form' => $form->createView(),
            'album' => $album,
            'genres' => $genres,
        ]);
    }

    #[Route('/admin/album/upload'), ]
}
