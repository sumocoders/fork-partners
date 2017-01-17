<?php

namespace Backend\Modules\Partners\Domain\Widget\Command;

use Backend\Modules\Partners\Domain\Widget\Widget;
use Backend\Modules\Partners\Domain\Widget\WidgetDataTransferObject;

final class UpdateWidget extends WidgetDataTransferObject
{
    /**
     * @param Widget $widget
     */
    public function __construct(Widget $widget)
    {
        // make sure we have an existing Widget
        parent::__construct($widget);
    }
}
