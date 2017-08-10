<?php

namespace Backend\Modules\Partners\Domain\Partner;

use Common\Doctrine\Type\AbstractFileType;
use Common\Doctrine\ValueObject\AbstractFile;

class ImageDBALType extends AbstractFileType
{
    protected function createFromString(string $fileName): AbstractFile
    {
        return Image::fromString($fileName);
    }

    public function getName()
    {
        return 'partners_partner_image';
    }
}
