<?php

namespace Backend\Modules\Partners\Domain\Widget;

use Backend\Modules\Partners\Domain\Partner\PartnerType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Valid;

class WidgetType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'title',
            TextType::class,
            [
                'label' => 'lbl.Title',
            ]
        )->add(
            'partners',
            CollectionType::class,
            [
                'label' => 'lbl.Partners',
                'type' => PartnerType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'constraints' => [new Valid()],
                'attr' => [
                    'data-collection' => 'partners'
                ]
            ]
        );
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => WidgetDataTransferObject::class,
                'error_bubbling' => false,
            ]
        );
    }
}
