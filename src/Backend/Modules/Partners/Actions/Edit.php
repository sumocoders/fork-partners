<?php

namespace Backend\Modules\Partners\Actions;

use Backend\Core\Engine\Base\ActionEdit;
use Backend\Core\Engine\Model;
use Backend\Modules\Partners\Domain\Widget\Command\UpdateWidget;
use Backend\Modules\Partners\Domain\Widget\Widget;
use Backend\Modules\Partners\Domain\Widget\WidgetType;

class Edit extends ActionEdit
{
    public function execute()
    {
        parent::execute();
        $widget = $this->get('partners.repository.widget')->find(
            $this->getParameter('id', 'int')
        );

        if (!$widget instanceof Widget) {
            return $this->redirect(Model::createURLForAction('Index', null, null, ['error' => 'non-existing']));
        }

        $editWidget = new UpdateWidget($widget);

        $theme = $this->get('fork.settings')->get('Core', 'theme', 'core');
        $form = $this->createForm(new WidgetType($theme), $editWidget);

        $form->handleRequest($this->get('request'));
        if (!$form->isValid()) {
            $this->tpl->assign('form', $form->createView());
            $this->tpl->assign('widget', $widget);

            $this->display();

            return;
        }

        $this->get('command_bus')->handle($form->getData());

        return $this->redirect(
            Model::createURLForAction(
                'Index',
                null,
                null,
                [
                    'report' => 'edited',
                    'var' => $editWidget->title,
                ]
            )
        );
    }
}
