<?php

namespace App\Controller\Admin;

use App\Entity\Chapter;
use App\Form\Admin\ChapterType;
use App\Repository\ChapterRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/chapter')]
final class ChapterController extends AbstractController
{
    #[Route(name: 'admin_chapter_index', methods: ['GET'])]
    public function index(ChapterRepository $chapterRepository): Response
    {
        return $this->render('admin/chapter/index.html.twig', [
            'chapters' => $chapterRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'admin_chapter_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $chapter = new Chapter();
        $form = $this->createForm(ChapterType::class, $chapter);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($chapter);
            $entityManager->flush();

            return $this->redirectToRoute('admin_chapter_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/chapter/new.html.twig', [
            'chapter' => $chapter,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'admin_chapter_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Chapter $chapter, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ChapterType::class, $chapter);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('admin_chapter_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/chapter/edit.html.twig', [
            'chapter' => $chapter,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'admin_chapter_delete', methods: ['POST'])]
    public function delete(Request $request, Chapter $chapter, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$chapter->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($chapter);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_chapter_index', [], Response::HTTP_SEE_OTHER);
    }
}
