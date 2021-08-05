<?php

declare(strict_types=1);

namespace App\Exception;

use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormErrorIterator;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class InvalidFormException extends BadRequestHttpException
{
    /**
     * @var FormInterface<mixed>
     */
    private $form;

    /**
     * @var array<string, mixed> $errors
     */
    public array $errors;

    /**
     * @param FormInterface<mixed> $form
     * @param array<string, string> $headers
     */
    public function __construct(FormInterface $form, ?string $message = '', \Throwable $previous = null, int $code = 0, array $headers = [])
    {
        parent::__construct($message, $previous, $code, $headers);

        $this->form = $form;
        $this->errors = self::formatFormError($form);
    }

    /**
     * @param array<string, mixed> $errors
     */
    public function setErrors($errors): void
    {
        $this->errors = $errors;
    }

    /**
     * @return array<string, mixed>
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * @return FormInterface<mixed>
     */
    public function getForm(): FormInterface
    {
        return $this->form;
    }

    /**
     * @param FormInterface<mixed> $form
     * @return array<mixed>
     */
    protected static function formatFormError(FormInterface $form): array
    {
        $result = [];

        foreach ($form->getErrors(true, true) as $formError) {
            if ($formError instanceof FormError) {
                /** @phpstan-ignore-next-line */
                $result[$formError->getOrigin()->getName()] = $formError->getMessage();
            } elseif ($formError instanceof FormErrorIterator) {
                $result[$formError->getForm()->getName()] = self::formatFormError($formError->getForm());
            }
        }

        return $result;
    }
}
