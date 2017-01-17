<?php

namespace Backend\Modules\Partners\Domain\Widget\Command;

use Backend\Modules\Partners\Domain\Widget\Widget;

class UpdateWidgetHandler
{
    /**
     * @param UpdateWidget $updateWidget
     */
    public function handle(UpdateWidget $updateWidget)
    {
        Widget::fromDataTransferObject($updateWidget);
    }
}
