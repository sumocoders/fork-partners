<?php

namespace Backend\Modules\Partners\Installer;

use Backend\Core\Engine\Model;
use Backend\Core\Installer\ModuleInstaller;
use Backend\Modules\Partners\Domain\Partner\Partner;
use Backend\Modules\Partners\Domain\Widget\Widget;

class Installer extends ModuleInstaller
{
    public function install()
    {
        Model::get('fork.entity.create_schema')->forEntityClasses(
            [Widget::class, Partner::class]
        );

        $this->addModule('Partners');

        $this->importLocale(__DIR__ . '/Data/locale.xml');

        $this->setModuleRights(1, 'Partners');
        $this->setActionRights(1, 'Partners', 'Index');
        $this->setActionRights(1, 'Partners', 'Add');
        $this->setActionRights(1, 'Partners', 'Edit');
        $this->setActionRights(1, 'Partners', 'Delete');

        $navigationModulesId = $this->setNavigation(null, 'Modules');

        $this->setNavigation(
            $navigationModulesId,
            'Partners',
            'partners/index',
            [
                'partners/add',
                'partners/edit',
            ]
        );
    }
}
