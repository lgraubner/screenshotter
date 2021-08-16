<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Exception\InvalidFormException;
use App\Form\ScreenshotType;
use App\Model\Screenshot;
use App\Service\ArrayUtils;
use App\Service\ScreenshotService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\HeaderUtils;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ScreenshotController extends AbstractController
{
    private ScreenshotService $ScreenshotService;
    private ArrayUtils $arrayUtils;

    public function __construct(ScreenshotService $ScreenshotService, ArrayUtils $arrayUtils)
    {
        $this->ScreenshotService = $ScreenshotService;
        $this->arrayUtils = $arrayUtils;
    }

    /**
     * @Route("/screenshot", name="app_screenshot", methods={"POST"})
     */
    public function index(Request $request): Response
    {
        $data = $request->request->all();

        $form = $this->createForm(ScreenshotType::class);
        $form->submit($data);

        $parameters = $this->arrayUtils->pick($data, ['delay', 'quality', 'fullPage', 'width', 'height']);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Screenshot $screenshot */
            $screenshot = $this->ScreenshotService->execute($data['url'], $parameters);

            $response = new BinaryFileResponse($screenshot->getPath());

            $disposition = HeaderUtils::makeDisposition(
                HeaderUtils::DISPOSITION_INLINE,
                $screenshot->getFilename()
            );

            $response->headers->set('Content-Disposition', $disposition);

            return $response;
        }

        throw new InvalidFormException($form, 'Invalid data');
    }
}
