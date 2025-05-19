<?php

namespace App\Controller;

use App\Entity\Album;
use App\Form\AlbumType;
use App\Repository\AlbumRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AdminAlbumController extends AbstractController
{
    #[Route('/admin/album', name: 'app_admin_album')]
    public function index(
        Request $request,
        EntityManagerInterface $entityManager,
        AlbumRepository $albumRepository
    ): Response {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $albums = $albumRepository->findAll(); // <-- Correction ici

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
            'form' => $form->createView(),
        ]);
    }

    #[Route('/admin/album/delete/{id}', name: 'admin_album_delete', methods: ['POST'])]
    public function delete(Album $album, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $entityManager->remove($album);
        $entityManager->flush();
        $this->addFlash('success', 'Album supprimé avec succès !');

        return $this->redirectToRoute('app_admin_album');
    }
}
