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
     * @var FormInterface
     */
    private $form;

    public $errors;

    public function __construct(FormInterface $form, ?string $message = '', \Throwable $previous = null, int $code = 0, array $headers = [])
    {
        parent::__construct($message, $previous, $code, $headers);

        $this->form = $form;
        $this->errors = self::formatFormError($form);
    }

    public function setErrors($errors)
    {
        $this->errors = $errors;
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function getForm(): FormInterface
    {
        return $this->form;
    }

    protected static function formatFormError(FormInterface $form)
    {
        $result = [];

        foreach ($form->getErrors(true, true) as $formError) {
            if ($formError instanceof FormError) {
                $result[$formError->getOrigin()->getName()] = $formError->getMessage();
            } elseif ($formError instanceof FormErrorIterator) {
                $result[$formError->getForm()->getName()] = self::formatFormError($formError->getForm());
            }
        }

        return $result;
    }
}
