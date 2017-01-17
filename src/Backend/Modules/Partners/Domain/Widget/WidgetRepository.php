<?php

namespace Backend\Modules\Partners\Domain\Widget;

use Doctrine\ORM\EntityRepository;

class WidgetRepository extends EntityRepository
{
    /**
     * @param Widget $widget
     */
    public function add(Widget $widget)
    {
        $this->getEntityManager()->persist($widget);
    }

    /**
     * @param Widget $widget
     */
    public function remove(Widget $widget)
    {
        $this->getEntityManager()->remove($widget);
    }
}
