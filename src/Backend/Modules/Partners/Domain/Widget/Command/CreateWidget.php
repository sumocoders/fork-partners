<?php

namespace Backend\Modules\Partners\Domain\Widget\Command;

use Backend\Modules\Partners\Domain\Widget\WidgetDataTransferObject;

final class CreateWidget extends WidgetDataTransferObject
{
    public function __construct()
    {
        // make it impossible to add an existing Widget via the constructor
        parent::__construct();
    }
}
