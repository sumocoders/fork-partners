<?php

namespace Frontend\Modules\Partners\Widgets;

use Frontend\Core\Engine\Base\Widget as FrontendBaseWidget;

class Slideshow extends FrontendBaseWidget
{
    public function execute()
    {
        parent::execute();
        $this->loadTemplate();
        $this->tpl->assign(
            'partners',
            $this->get('partners.repository.widget')->find($this->data['id'])->getPartners()
        );
    }
}
