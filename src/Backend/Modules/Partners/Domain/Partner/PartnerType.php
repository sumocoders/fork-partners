<?php

namespace Backend\Modules\Partners\Domain\Partner;

use Backend\Form\Type\ImageType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PartnerType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'name',
            TextType::class,
            [
                'label' => 'lbl.Name',
            ]
        )->add(
            'image',
            ImageType::class,
            [
                'label' => 'lbl.image',
                'image_class' => Image::class,
            ]
        )->add(
            'url',
            UrlType::class,
            [
                'label' => 'lbl.URL',
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
                'data_class' => PartnerDataTransferObject::class,
                'error_bubbling' => false,
            ]
        );
    }
}
