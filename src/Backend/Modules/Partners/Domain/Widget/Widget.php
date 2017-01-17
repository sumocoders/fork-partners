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
     */
    private $partners;

    /**
     * @param int $widgetId
     * @param string $title
     */
    public function __construct($widgetId, $title)
    {
        $this->widgetId = $widgetId;
        $this->title = $title;
        $this->partners = new ArrayCollection();
    }

    /**
     * @param string $title
     */
    public function update($title)
    {
        $this->title = $title;
    }

    /**
     * @ORM\PostUpdate
     * @ORM\PostPersist
     */
    public function updateWidget()
    {
        $editUrl = Model::createURLForAction('EditWidget', 'Partners') . '&id=' . $this->id;
        $extras = Model::getExtras([$this->widgetId]);
        $extra = reset($extras);
        $data = $extra['data'];
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
     * @param WidgetDataTransferObject $widgetDataTransferObject
     *
     * @return Widget
     */
    public static function fromDataTransferObject(WidgetDataTransferObject $widgetDataTransferObject)
    {
        if ($widgetDataTransferObject->hasExistingWidget()) {
            $widget = $widgetDataTransferObject->getWidgetEntity();

            $widget->title = $widgetDataTransferObject->title;
            $widget->partners = $widgetDataTransferObject = $widgetDataTransferObject->partners->map(
                function (PartnerDataTransferObject $partnerDataTransferObject) use ($widget) {
                    return Partner::fromDataTransferObject($partnerDataTransferObject, $widget);
                }
            );

            return $widget;
        }

        $widget = new self(
            Model::insertExtra(
                ModuleExtraType::widget(),
                'Partners',
                'Slideshow'
            ),
            $widgetDataTransferObject->title
        );

        $widget->partners = $widgetDataTransferObject = $widgetDataTransferObject->partners->map(
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
