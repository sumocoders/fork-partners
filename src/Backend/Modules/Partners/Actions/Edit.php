<?php

namespace Backend\Modules\Partners\Actions;

use Backend\Core\Engine\Base\ActionEdit;
use Backend\Core\Engine\Model;
use Backend\Modules\Partners\Domain\Widget\Command\UpdateWidget;
use Backend\Modules\Partners\Domain\Widget\Widget;
use Backend\Modules\Partners\Domain\Widget\WidgetType;

class Edit extends ActionEdit
{
    public function execute(): void
    {
        parent::execute();
        $widget = $this->get('partners.repository.widget')->find(
            $this->getRequest()->query->getInt('id')
        );

        if (!$widget instanceof Widget) {
            $this->redirect(Model::createURLForAction('Index', null, null, ['error' => 'non-existing']));
            return;
        }

        $editWidget = new UpdateWidget($widget);
        $form = $this->createForm(WidgetType::class, $editWidget);

        $form->handleRequest($this->getRequest());
        if (!$form->isValid()) {
            $this->template->assign('form', $form->createView());
            $this->template->assign('widget', $widget);

            $this->display();

            return;
        }

        $this->get('command_bus')->handle($form->getData());

        $this->redirect(
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
        return;
    }
}
