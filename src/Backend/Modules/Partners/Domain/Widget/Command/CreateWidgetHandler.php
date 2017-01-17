<?php

namespace Backend\Modules\Partners\Domain\Widget\Command;

use Backend\Modules\Partners\Domain\Widget\Widget;
use Backend\Modules\Partners\Domain\Widget\WidgetRepository;

class CreateWidgetHandler
{
    /** @var WidgetRepository */
    private $widgetRepository;

    /**
     * @param WidgetRepository $widgetRepository
     */
    public function __construct(WidgetRepository $widgetRepository)
    {
        $this->widgetRepository = $widgetRepository;
    }

    /**
     * @param CreateWidget $createWidget
     */
    public function handle(CreateWidget $createWidget)
    {
        $this->widgetRepository->add(
            Widget::fromDataTransferObject($createWidget)
        );
    }
}
