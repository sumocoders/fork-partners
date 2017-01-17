<?php

namespace Backend\Modules\Partners\Domain\Partner;

use Common\Doctrine\ValueObject\AbstractImage;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

class Image extends AbstractImage
{
    /**
     * @var UploadedFile
     *
     * @Assert\File(
     *     maxSize = "2M",
     *     mimeTypes = {"image/jpeg", "image/gif", "image/png"},
     *     mimeTypesMessage = "err.JPGGIFAndPNGOnly"
     * )
     */
    protected $file;

    /**
     * @return string
     */
    protected function getUploadDir()
    {
        return 'Partners/Partner/Image';
    }
}
