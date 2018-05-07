<?php

namespace Backend\Modules\Partners\Domain\Widget;

use Backend\Core\Engine\Model;
use Backend\Modules\Partners\Domain\Partner\Partner;
use Backend\Modules\Partners\Domain\Partner\PartnerDataTransferObject;
use Common\ModuleExtraType;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="PartnersWidget")
 * @ORM\Entity(repositoryClass="WidgetRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Widget
{
    const DEFAULT_TEMPLATE = 'Partners.html.twig';

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
     * @ORM\Column(type="string", length=255, options={"default" = "Partners.html.twig"})
     */
    private $template = 'Partners.html.twig';

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
            'Partners'
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
        $data['custom_template'] = $this->template;

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
            $widget->partners->clear();

            /** @var PartnerDataTransferObject $partnerDataTransferObject */
            foreach ($widgetDataTransferObject->partners as $partnerDataTransferObject) {
                $widget->partners->add(Partner::fromDataTransferObject($partnerDataTransferObject, $widget));
            }

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
     * @return Partner[]|Collection
     */
    public function getPartners()
    {
        return $this->partners;
    }
}
