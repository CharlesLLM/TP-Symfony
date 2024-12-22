<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class DefaultController extends AbstractController
{
    #[Route(path: '/', name: 'app_home', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('app/home/index.html.twig');
    }

    #[Route(path: '/subject/{slug}', name: 'app_subject_show', methods: ['GET'])]
    public function subject(Subject $subject, Request $request): Response
    {
        return $this->render('app/subject/view.html.twig', [
            'subject' => $subject,
        ]);
    }

    #[Route(path: '/banned', name: 'app_banned', methods: ['GET'])]
    public function banned(): Response
    {
        return $this->render('app/banned.html.twig');
    }
}
