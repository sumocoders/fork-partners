<?php

namespace Backend\Modules\Partners\Domain\Widget\Command;

use Backend\Modules\Partners\Domain\Widget\Widget;

final class DeleteWidget
{
    /** @var Widget */
    private $widget;

    /**
     * @param Widget $widget
     */
    public function __construct(Widget $widget)
    {
        $this->widget = $widget;
    }

    /**
     * @return Widget
     */
    public function getWidget()
    {
        return $this->widget;
    }
}
