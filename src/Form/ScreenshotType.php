<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\LessThanOrEqual;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Positive;
use Symfony\Component\Validator\Constraints\PositiveOrZero;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Validator\Constraints\Url;

class ScreenshotType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('url', TextType::class, [
                'required' => true,
                'constraints' => [
                    new NotBlank(),
                    new Url(),
                ],
            ])
            ->add('fullPage', CheckboxType::class, [
                'required' => false,
                'constraints' => [
                    new NotBlank(),
                    new Type([
                        'value' => 'bool'
                    ])
                ],
            ])
            ->add('quality', NumberType::class, [
                'required' => false,
                'constraints' => [
                    new NotBlank(),
                    new PositiveOrZero(),
                    new LessThanOrEqual([
                        'value' => 100,
                    ]),
                ],
            ])
            ->add('delay', NumberType::class, [
                'required' => false,
                'constraints' => [
                    new NotBlank(),
                    new Positive(),
                    new LessThanOrEqual([
                        'value' => 10000, // 10 seconds
                    ]),
                ],
            ])
            ->add('width', NumberType::class, [
                'required' => false,
                'constraints' => [
                    new NotBlank(),
                    new Positive(),
                    new LessThanOrEqual([
                        'value' => 2000,
                    ]),
                ],
            ])
            ->add('height', NumberType::class, [
                'required' => false,
                'constraints' => [
                    new NotBlank(),
                    new Positive(),
                    new LessThanOrEqual([
                        'value' => 2000,
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'csrf_protection' => false,
        ]);
    }
}
