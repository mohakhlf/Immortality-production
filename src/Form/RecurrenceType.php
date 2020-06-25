<?php

namespace App\Form;

use App\Entity\Recurrence;
use App\Entity\Treatment;
use Doctrine\DBAL\Types\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RecurrenceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('morning')
            ->add('noon')
            ->add('evening')
            ->add('start', \Symfony\Component\Form\Extension\Core\Type\DateType::class, [
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd'
            ])
            ->add('treatment', EntityType::class, [
                'class'=>Treatment::class,
                'choice_label'=>'id',
                'attr'=>['disabled'=>'disabled']
            ])
            ->add('drug')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Recurrence::class,
        ]);
    }
}
