<?php

namespace Backend\Modules\Partners\Domain\Partner;

use Common\Doctrine\Type\AbstractFileType;

class ImageDBALType extends AbstractFileType
{
    /**
     * @param string $fileName
     *
     * @return Image
     */
    protected function createFromString($fileName)
    {
        return Image::fromString($fileName);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'partners_partner_image';
    }
}
