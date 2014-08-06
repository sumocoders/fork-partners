<?php

namespace Backend\Modules\Partners\Installer;

/*
 * This file is part of Fork CMS.
 *
 * For the full copyright and license information, please view the license
 * file that was distributed with this source code.
 */

use Backend\Core\Installer\ModuleInstaller;
use Symfony\Component\Filesystem\Filesystem;
use Frontend\Modules\Partners\Engine\Model as FrontendPartnersModel;

/**
 * This class will install the partners module.
 *
 * @author Jelmer Prins <jelmer@cumocoders.be>
 */
class Installer extends ModuleInstaller
{
    /**
     * Install the module
     */
    public function install()
    {
        $this->importSQL(dirname(__FILE__) . '/Data/install.sql');

        $this->addModule('Partners');

        $this->importLocale(dirname(__FILE__) . '/Data/locale.xml');

        $this->makeSearchable('Partners');

        $this->setModuleRights(1, 'Partners');
        $this->setActionRights(1, 'Partners', 'Index');
        $this->setActionRights(1, 'Partners', 'Add');
        $this->setActionRights(1, 'Partners', 'Edit');
        $this->setActionRights(1, 'Partners', 'Delete');
        $this->setActionRights(1, 'Partners', 'AddPartner');
        $this->setActionRights(1, 'Partners', 'EditPartner');
        $this->setActionRights(1, 'Partners', 'DeletePartner');

        // set navigation
        $navigationModulesId = $this->setNavigation(null, 'Modules');
        $this->setNavigation(
            $navigationModulesId,
            'Partners',
            'partners/index',
            array(
                'partners/add',
                'partners/addPartner',
                'partners/edit',
                'partners/editPartner',
                'partners/index'
            )
        );

        $fs = new Filesystem();
        $fs->mkdir(
            FRONTEND_FILES_PATH . '/' . FrontendPartnersModel::IMAGE_PATH
        );
    }
}
