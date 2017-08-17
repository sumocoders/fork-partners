<?php

namespace Frontend\Modules\Partners\Widgets;

use Frontend\Core\Engine\Base\Widget as FrontendBaseWidget;

class Slideshow extends FrontendBaseWidget
{
    public function execute(): void
    {
        parent::execute();
        $this->template->assign(
            'partners',
            $this->get('partners.repository.widget')->find($this->data['id'])->getPartners()
        );
    }
}
