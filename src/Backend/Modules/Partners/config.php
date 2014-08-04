<?php

namespace Backend\Modules\Partners;

/*
 * This file is part of Fork CMS.
 *
 * For the full copyright and license information, please view the license
 * file that was distributed with this source code.
 */

use Backend\Core\Engine\Base\Config as BackendBaseConfig;

/**
 * Config for the Partners module
 *
 * @author Jelmer Prins <jelmer@sumocoders.be>
 */
final class Config extends BackendBaseConfig
{
    /**
     * The default action
     *
     * @var    string
     */
    protected $defaultAction = 'Index';

    /**
     * The disabled actions
     *
     * @var    array
     */
    protected $disabledActions = array();

    /**
     * The disabled AJAX-actions
     *
     * @var	array
     */
    protected $disabledAJAXActions = array();
}
