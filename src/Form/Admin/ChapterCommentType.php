<?php

namespace App\Form\Admin;

use App\Entity\Comment;
use App\Enum\CommentStatusEnum;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChapterCommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('content', TextareaType::class, [
                'attr' => ['class' => 'border rounded-lg px-3 py-2 mt-1 mb-5 text-sm w-full'],
                'label_attr' => ['class' => 'font-semibold text-sm text-gray-600 pb-1 block'],
            ])
            ->add('status', EnumType::class, [
                'class' => CommentStatusEnum::class,
                'required' => true,
                'attr' => ['class' => 'border rounded-lg px-3 py-2 mt-1 mb-5 text-sm w-full'],
                'label_attr' => ['class' => 'font-semibold text-sm text-gray-600 pb-1 block'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Comment::class,
        ]);
    }
}
