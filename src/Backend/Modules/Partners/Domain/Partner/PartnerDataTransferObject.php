<?php

namespace Backend\Modules\Partners\Domain\Partner;

use Symfony\Component\Validator\Constraints as Assert;

class PartnerDataTransferObject
{
    /**
     * @var Partner|null
     */
    private $partnerEntity;

    /**
     * @var Image
     */
    public $image;

    /**
     * @var string
     *
     * @Assert\NotBlank(message="err.FieldIsRequired")
     */
    public $name;

    /**
     * @var int
     */
    public $sequence = 0;

    /**
     * @var string
     *
     * @Assert\NotBlank(message="err.FieldIsRequired")
     * @Assert\Url(message="err.InvalidURL")
     */
    public $url;

    /**
     * @param Partner|null $partner
     */
    public function __construct(Partner $partner = null)
    {
        $this->partnerEntity = $partner;

        if (!$this->hasExistingPartner()) {
            return;
        }

        $this->sequence = $partner->getSequence();
        $this->image = $partner->getImage();
        $this->name = $partner->getName();
        $this->url = $partner->getUrl();
    }

    /**
     * @return bool
     */
    public function hasExistingPartner()
    {
        return $this->partnerEntity instanceof Partner;
    }

    /**
     * @return Partner
     */
    public function getPartnerEntity()
    {
        return $this->partnerEntity;
    }
}
