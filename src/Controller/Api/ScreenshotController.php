<?php

namespace App\Controller\Api;

use App\Exception\InvalidFormException;
use App\Form\ScreenshotType;
use App\Model\Screenshot;
use App\Service\ArrayUtilsService;
use App\Service\ScreenshotService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\HeaderUtils;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ScreenshotController extends AbstractController
{
    /**
     * @Route("/screenshot", name="app_screenshot", methods={"POST", "GET"})
     */
    public function index(Request $request): Response
    {
        $data = array_merge($request->request->all(), $request->query->all());

        $form = $this->createForm(ScreenshotType::class);
        $form->submit($data);

        $parameters = $this->get(ArrayUtilsService::class)->pick(['delay', 'quality', 'fullPage', 'width', 'height']);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Screenshot $screenshot */
            $screenshot = $this->get(ScreenshotService::class)->execute($data['url'], $parameters);

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

    public static function getSubscribedServices(): array
    {
        return array_merge(parent::getSubscribedServices(), [
            ScreenshotService::class,
            ArrayUtilsService::class,
        ]);
    }
}
