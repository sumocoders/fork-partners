<?php

namespace Backend\Modules\Partners\Actions;

use Backend\Core\Engine\Base\ActionIndex;
use Backend\Modules\Partners\Domain\Widget\WidgetDataGrid;

class Index extends ActionIndex
{
    public function execute(): void
    {
        parent::execute();
        $this->template->assign('dataGrid', WidgetDataGrid::getHtml());
        $this->display();
    }
}
