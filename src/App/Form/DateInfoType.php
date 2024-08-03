<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints\Timezone;
use App\DTO\DateInfoFormData;

class DateInfoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date', TextType::class, [
                'label' => 'Date',
                'constraints' => [
                    new NotBlank(),
                    new Date([
                        'message' => 'Please enter a valid date in Y-m-d format.',
                    ]),
                ],
            ])
            ->add('timezone', TextType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Timezone([
                        'message' => 'Please enter a valid timezone (e.g. Europe/London).',
                    ]),
                ],
            ]);
    }

    /**
     * @param OptionsResolver $resolver
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => DateInfoFormData::class,
        ]);
    }
}