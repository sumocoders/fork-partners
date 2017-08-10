<?php

namespace Backend\Modules\Partners\Domain\Widget;

use Backend\Core\Engine\Authentication;
use Backend\Core\Engine\DataGridDatabase;
use Backend\Core\Engine\Model;
use Backend\Core\Language\Language;

class WidgetDataGrid extends DataGridDatabase
{
    public function __construct()
    {
        parent::__construct(
            'SELECT w.id, w.title
             FROM PartnersWidget w'
        );

        if (Authentication::isAllowedAction('Edit')) {
            $editUrl = Model::createURLForAction('Edit', null, null, ['id' => '[id]'], false);
            $this->setColumnURL('title', $editUrl);
            $this->addColumn('edit', null, Language::lbl('Edit'), $editUrl, Language::lbl('Edit'));
        }
    }

    /**
     * @return string
     */
    public static function getHtml()
    {
        $dataGrid = new self();

        return (string) $dataGrid->getContent();
    }
}
