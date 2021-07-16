<?php

declare(strict_types=1);

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HealthController extends AbstractController
{
    /**
     * @Route("/health", name="app_health", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->json([
            'status' => 'ok',
        ]);
    }
}
