<?php

namespace Backend\Modules\Partners\Ajax;

    /*
     * This file is part of Fork CMS.
     *
     * For the full copyright and license information, please view the license
     * file that was distributed with this source code.
     */

/**
 * Re-order the partners
 *
 * @author Jelmer Prins <jelmer@sumocoders.be>
 */

use Backend\Core\Engine\Base\AjaxAction as BackendBaseAJAXAction;
use Backend\Modules\Partners\Engine\Model as BackendPartnersModel;

class Sequence extends BackendBaseAJAXAction
{
    /**
     * Execute the action
     */
    public function execute()
    {
        // get parameters
        $newIdSequence = trim(\SpoonFilter::getPostValue('new_id_sequence', null, '', 'string'));

        // list id
        $ids = (array) explode(',', rtrim($newIdSequence, ','));
        $count = 0;

        // loop id's and set new sequence
        foreach ($ids as $i => $id) {
            // build item
            $item['id'] = (int) $id;

            // change sequence
            $item['sequence'] = ++$count;

            // update sequence
            if (BackendPartnersModel::partnerExists($item['id'])) {
                BackendPartnersModel::updatePartner($item);
            }
        }

        // success output
        $this->output(self::OK, null, 'sequence updated');
        parent::execute();
    }
}
