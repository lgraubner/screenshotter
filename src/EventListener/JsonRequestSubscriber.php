<?php

declare(strict_types=1);

namespace App\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class JsonRequestSubscriber implements EventSubscriberInterface
{
    public function onKernelRequest(RequestEvent $event): void
    {
        $request = $event->getRequest();
        $content = $request->getContent();

        if ('json' !== $request->getContentType() || empty($content)) {
            return;
        }

        $data = json_decode((string) $content, true);

        if (JSON_ERROR_NONE !== json_last_error()) {
            throw new BadRequestHttpException('Unable to parse request.');
        }

        $request->request->replace($data);
    }

    /**
     * @return array<string, string>
     */
    public static function getSubscribedEvents(): array
    {
        return [
            RequestEvent::class => 'onKernelRequest',
        ];
    }
}
