<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

final class DefaultController extends AbstractController
{
    #[Route('/')]
    public function index(): JsonResponse
    {
        return $this->json([
            'Please read the README file.'
        ]);
    }
}
