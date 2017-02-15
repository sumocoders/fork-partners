<?php

namespace Backend\Modules\Partners\Domain\Widget;

use Backend\Core\Engine\Model;
use Backend\Modules\Partners\Domain\Partner\Partner;
use Backend\Modules\Partners\Domain\Partner\PartnerDataTransferObject;
use Common\ModuleExtraType;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Finder\Finder;

/**
 * @ORM\Table(name="PartnersWidget")
 * @ORM\Entity(repositoryClass="WidgetRepository")
 * @ORM\HasLifecycleCallbacks
 */
final class Widget
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $widgetId;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @var Collection|Partner[]
     *
     * @ORM\OneToMany(
     *     targetEntity="Backend\Modules\Partners\Domain\Partner\Partner",
     *     mappedBy="widget",
     *     orphanRemoval=true, cascade={"persist"}
     * )
     * @ORM\OrderBy({"sequence" = "ASC"})
     */
    private $partners;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    private $template;

    /**
     * @param string $title
     * @param string $template
     */
    public function __construct($title, $template)
    {
        $this->title = $title;
        $this->template = $template;
        $this->partners = new ArrayCollection();
    }

    /**
     * @ORM\PostRemove
     */
    public function deleteWidget()
    {
        Model::deleteExtraById($this->widgetId, true);
    }

    /**
     * @ORM\PrePersist
     */
    public function createWidget()
    {
        $this->widgetId = Model::insertExtra(
            ModuleExtraType::widget(),
            'Partners',
            'Slideshow'
        );
    }

    /**
     * @ORM\PostUpdate
     * @ORM\PostPersist
     */
    public function updateWidget()
    {
        $editUrl = Model::createURLForAction('Edit', 'Partners') . '&id=' . $this->id;
        $extras = Model::getExtras([$this->widgetId]);
        $extra = reset($extras);
        $data = (array) $extra['data'];
        $data['id'] = $this->id;
        $data['edit_url'] = $editUrl;
        $data['extra_label'] = $this->title;

        Model::updateExtra($this->widgetId, 'data', $data);
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * @return string
     */
    public function getTemplatePath()
    {
        $theme = Model::get('fork.settings')->get('Core', 'theme', 'core');

        $path = FRONTEND_MODULES_PATH . '/Partners/Layout/Widgets/' . $this->getTemplate();
        
        if ($theme != 'core' && file_exists(FRONTEND_PATH . '/Themes/' . $theme . '/Modules/Partners/Layout/Widgets/' . $this->getTemplate())) {
            $path = FRONTEND_PATH . '/Themes/' . $theme . '/Modules/Partners/Layout/Widgets/' . $this->getTemplate();
        }

        if (!file_exists($path)) {
            $path = FRONTEND_MODULES_PATH . '/Partners/Layout/Widgets/Slideshow.html.twig';
        }

        return $path;
    }

    /**
     * @param WidgetDataTransferObject $widgetDataTransferObject
     *
     * @return Widget
     */
    public static function fromDataTransferObject(WidgetDataTransferObject $widgetDataTransferObject)
    {
        if ($widgetDataTransferObject->hasExistingWidget()) {
            $widget = $widgetDataTransferObject->getWidgetEntity();

            $widget->title = $widgetDataTransferObject->title;
            $widget->template = $widgetDataTransferObject->template;
            $widget->partners = $widgetDataTransferObject->partners->map(
                function (PartnerDataTransferObject $partnerDataTransferObject) use ($widget) {
                    return Partner::fromDataTransferObject($partnerDataTransferObject, $widget);
                }
            );

            return $widget;
        }

        $widget = new self($widgetDataTransferObject->title, $widgetDataTransferObject->template);

        $widget->partners = $widgetDataTransferObject->partners->map(
            function (PartnerDataTransferObject $partnerDataTransferObject) use ($widget) {
                return Partner::fromDataTransferObject($partnerDataTransferObject, $widget);
            }
        );

        return $widget;
    }

    /**
     * Get templates.
     *
     * @return array
     */
    public static function getTemplates()
    {
        $templates = array();
        $finder = new Finder();
        $finder->name('*.html.twig');
        $finder->in(FRONTEND_MODULES_PATH . '/Partners/Layout/Widgets');
        // if there is a custom theme we should include the templates there also
        $theme = Model::get('fork.settings')->get('Core', 'theme', 'core');
        if ($theme != 'core') {
            $path = FRONTEND_PATH . '/Themes/' . $theme . '/Modules/Partners/Layout/Widgets';
            if (is_dir($path)) {
                $finder->in($path);
            }
        }
        foreach ($finder->files() as $file) {
            $templates[] = $file->getBasename();
        }
        return array_unique($templates);
    }

    /**
     * @return Partner[]|Collection
     */
    public function getPartners()
    {
        return $this->partners;
    }
}
