<?php

namespace Frontend\Modules\Partners\Widgets;

use Backend\Modules\Partners\Domain\Widget\Widget;
use Frontend\Core\Engine\Base\Widget as FrontendBaseWidget;
use Frontend\Core\Engine\Theme;

class Slideshow extends FrontendBaseWidget
{
    public function execute()
    {
        parent::execute();

        /** @var Widget $widget */
        $widget = $this->get('partners.repository.widget')->find($this->data['id']);

        $template = Theme::getPath($widget->getTemplatePath());
        $this->loadTemplate($template);


        $this->tpl->assign(
            'partners',
            $widget->getPartners()
        );
    }
}
