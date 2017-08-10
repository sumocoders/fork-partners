<?php

namespace Backend\Modules\Partners\Actions;

use Backend\Core\Engine\Base\ActionDelete;
use Backend\Core\Engine\Model;
use Backend\Modules\Partners\Domain\Widget\Widget;
use Backend\Modules\Partners\Domain\Widget\Command\DeleteWidget;

class Delete extends ActionDelete
{
    public function execute(): void
    {
        $widget = $this->get('partners.repository.widget')->find(
            $this->getRequest()->query->getInt('id')
        );

        if (!$widget instanceof Widget) {
            $this->redirect(
                Model::createURLForAction(
                    'Index',
                    null,
                    null,
                    ['error' => 'non-existing']
                )
            );
        }
        $this->get('command_bus')->handle(new DeleteWidget($widget));

        $this->redirect(
            Model::createURLForAction(
                'Index',
                null,
                null,
                [
                    'report' => 'deleted',
                    'var' => $widget->getTitle(),
                ]
            )
        );
    }
}
