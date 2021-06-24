<?php

namespace App\Controller\Api;

use App\Form\ScreenshotType;
use App\Model\Screenshot;
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
    public function index(Request $request): Response
    {
        $form = $this->createForm(ScreenshotType::class);

        $data = array_merge($request->request->all(), $request->query->all());

        $form->submit($data);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Screenshot $screenshot */
            $screenshot = $this->get(ScreenshotService::class)->execute($data['url']);

            $response = new BinaryFileResponse($screenshot->getPath());

            $disposition = HeaderUtils::makeDisposition(
                HeaderUtils::DISPOSITION_INLINE,
                $screenshot->getFilename()
            );

            $response->headers->set('Content-Disposition', $disposition);

            return $response;
        }

        dump($form->getErrors(true));

        // @TODO: print errors
        throw new BadRequestHttpException('Invalid data');
    }

    public static function getSubscribedServices(): array
    {
        return array_merge(parent::getSubscribedServices(), [
            ScreenshotService::class,
        ]);
    }
}
