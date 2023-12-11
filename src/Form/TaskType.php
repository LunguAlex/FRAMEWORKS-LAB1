<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Task;
use DateTime;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class TaskType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => "Заголовок",
                'attr' => [
                    'placeholder' => "Введите заголовок",
                ],
                'constraints' => [
                    new Length(
                        min: 5,
                        max: 100,
                        minMessage: 'Заголовок должен содержать хотя бы {{ limit }} символов',
                        maxMessage: 'Ваш заголовок не может быть длиннее  {{ limit }} символов'
                    ),
                    new Regex(
                        pattern: "/[A-Za-z]*/",
                        message: 'В заголовке не должен содержать цифры!'

                    ),
                    new NotBlank(
                        message: 'Name cannot be blank'
                    )
                ]
            ])
            ->add('description', TextType::class, [
                'label' => "Описание",
                'attr' => [
                    'placeholder' => "Введите описание",
                ],
                'constraints' => [
                    new Length(
                        min: 5,
                        max: 100,
                        minMessage: 'Описание должно содержать хотя бы {{ limit }} символа',
                        maxMessage: 'Ваше описание не может быть длиннее  {{ limit }} символа'
                    )
                ]
            ])
            ->add('result')

            ->add('date', DateTimeType::class, [
                'date_label' => 'Date',
            ])
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name',
                'placeholder' => 'выберите категорию'
            ])
            ->add('submit', SubmitType::class, [
                'label' => "Создать",

            ]);
    }
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Task::class,
        ]);
    }
}
