<?php

namespace App\Controller\Api;

use App\Form\ScreenshotType;
use App\Service\ScreenshotService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;

class ScreenshotController extends AbstractController
{
    /**
     * @Route("/screenshot", name="app_screenshot", methods={"POST"})
     */
    public function index(Request $request, ScreenshotService $screenshotService): Response
    {
        $form = $this->createForm(ScreenshotType::class);

        $data = $request->request->all();

        $form->submit($data);

        if ($form->isSubmitted() && $form->isValid()) {
            $screenshotService->screenshot($form->getData()['url']);

            return $this->json([
                'success' => true,
            ]);
        }

        throw new BadRequestHttpException('Invalid data');
    }
}
