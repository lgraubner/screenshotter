<?php

namespace App\Controller\Api;

use App\Form\ScreenshotType;
use App\Service\ScreenshotService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\HeaderUtils;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;

class ScreenshotController extends AbstractController
{
    /**
     * @Route("/screenshot", name="app_screenshot", methods={"POST", "GET"})
     */
    public function index(Request $request, ScreenshotService $screenshotService): Response
    {
        $form = $this->createForm(ScreenshotType::class);

        $data = array_merge($request->request->all(), $request->query->all());

        $form->submit($data);

        if ($form->isSubmitted() && $form->isValid()) {
            $path = $screenshotService->execute($form->getData()['url']);

            $response = new BinaryFileResponse($path);

            $disposition = HeaderUtils::makeDisposition(
                HeaderUtils::DISPOSITION_INLINE,
                'foo.jpg'
            );

            $response->headers->set('Content-Disposition', $disposition);

            return $response;
        }

        throw new BadRequestHttpException('Invalid data');
    }
}
