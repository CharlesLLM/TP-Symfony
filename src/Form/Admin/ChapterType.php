<?php

namespace App\Form\Admin;

use App\Entity\Chapter;
use App\Entity\Tutorial;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChapterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('summary')
            ->add('videoUrl')
            ->add('tutorial', EntityType::class, [
                'class' => Tutorial::class,
                'choice_label' => 'name',
            ])
            ->add('comments', CollectionType::class, [
                'entry_type' => ChapterCommentType::class,
                'entry_options' => [
                    'label' => false,
                    'attr' => ['class' => 'border border-gray-300 rounded-xl p-5'],
                ],
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Chapter::class,
        ]);
    }
}
