<?php

namespace Backend\Modules\Partners\Domain\Widget\Command;

use Backend\Modules\Partners\Domain\Widget\WidgetRepository;

class DeleteWidgetHandler
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
     * @param DeleteWidget $deleteWidget
     */
    public function handle(DeleteWidget $deleteWidget)
    {
        $this->widgetRepository->remove($deleteWidget->getWidget());
    }
}
