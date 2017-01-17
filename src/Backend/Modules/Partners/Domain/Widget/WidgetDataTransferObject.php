<?php

namespace Backend\Modules\Partners\Domain\Widget;

use Backend\Modules\Partners\Domain\Partner\Partner;
use Backend\Modules\Partners\Domain\Partner\PartnerDataTransferObject;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;

class WidgetDataTransferObject
{
    /**
     * @var Widget|null
     */
    private $widgetEntity;

    /**
     * @var string
     *
     * @Assert\NotBlank(message="err.FieldIsRequired")
     */
    public $title;

    /**
     * @var Collection|PartnerDataTransferObject[]
     */
    public $partners;

    /**
     * @param Widget|null $widget
     */
    public function __construct(Widget $widget = null)
    {
        $this->widgetEntity = $widget;

        if (!$this->hasExistingWidget()) {
            $this->partners = new ArrayCollection();

            return;
        }

        $this->title = $widget->getTitle();
        $this->partners = $widget->getPartners()->map(
            function (Partner $partner) {
                return new PartnerDataTransferObject($partner);
            }
        );
    }

    /**
     * @return bool
     */
    public function hasExistingWidget()
    {
        return $this->widgetEntity instanceof Widget;
    }

    /**
     * @return Widget
     */
    public function getWidgetEntity()
    {
        return $this->widgetEntity;
    }
}
