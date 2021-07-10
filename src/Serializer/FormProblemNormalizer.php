<?php

namespace App\Serializer;

use App\Exception\InvalidFormException;
use Symfony\Component\ErrorHandler\Exception\FlattenException;
use Symfony\Component\Serializer\Exception\InvalidArgumentException;
use Symfony\Component\Serializer\Normalizer\CacheableSupportsMethodInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class FormProblemNormalizer implements NormalizerInterface, CacheableSupportsMethodInterface
{
    private $debug;
    private $defaultContext = [
        'type' => 'https://tools.ietf.org/html/rfc2616#section-10',
        'title' => 'An error occurred',
    ];

    public function __construct(bool $debug = false, array $defaultContext = [])
    {
        $this->debug = $debug;
        $this->defaultContext = $defaultContext + $this->defaultContext;
    }

    public function normalize($object, string $format = null, array $context = [])
    {
        if (!$object instanceof FlattenException) {
            throw new InvalidArgumentException(sprintf('The object must implement "%s".', FlattenException::class));
        }

        $context += $this->defaultContext;
        $debug = $this->debug && ($context['debug'] ?? true);

        $data = [
            'type' => $context['type'],
            'title' => $context['title'],
            'status' => $context['status'] ?? $object->getStatusCode(),
            'detail' => $debug ? $object->getMessage() : $object->getStatusText(),
        ];

        if ($context['exception'] instanceof InvalidFormException) {
            $data['errors'] = $context['exception']->getErrors();
        }

        if ($debug) {
            $data['class'] = $object->getClass();
            $data['trace'] = $object->getTrace();
        }

        return $data;
    }

    public function supportsNormalization($data, string $format = null): bool
    {
        return $data instanceof FlattenException;
    }

    public function hasCacheableSupportsMethod(): bool
    {
        return true;
    }
}
