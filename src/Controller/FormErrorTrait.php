<?php

namespace App\Controller;

use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormErrorIterator;
use Symfony\Component\Form\FormInterface;

trait FormErrorTrait
{
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
