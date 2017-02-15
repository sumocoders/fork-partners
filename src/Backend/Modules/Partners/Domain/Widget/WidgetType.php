<?php

namespace Backend\Modules\Partners\Domain\Widget;

use Backend\Modules\Partners\Domain\Partner\PartnerType;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Valid;

class WidgetType extends AbstractType
{
    /** @var string */
    private $theme;

    /**
     * @param string $theme
     */
    public function __construct($theme)
    {
        $this->theme = $theme;
    }

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

        $templates = $this->getPossibleTemplates();
        // if we have multiple templates, add a dropdown to select them
        if (count($templates) > 1) {
            $builder->add(
                'template',
                ChoiceType::class,
                [
                    'required' => true,
                    'label' => 'lbl.Template',
                    'choices' => $templates,
                    'choice_translation_domain' => false,
                ]
            );
        }
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

    /**
     * Get templates.
     *
     * @return array
     */
    private function getPossibleTemplates()
    {
        $templates = array();
        $finder = new Finder();
        $finder->name('*.html.twig');
        $finder->in(FRONTEND_MODULES_PATH . '/Partners/Layout/Widgets');
        // if there is a custom theme we should include the templates there also
        $theme = $this->theme;
        if ($theme != 'core') {
            $path = FRONTEND_PATH . '/Themes/' . $theme . '/Modules/Partners/Layout/Widgets';
            if (is_dir($path)) {
                $finder->in($path);
            }
        }
        foreach ($finder->files() as $file) {
            $templates[] = $file->getBasename();
        }

        return array_combine($templates, $templates);
    }
}
