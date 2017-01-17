<?php

namespace Backend\Modules\Partners\Domain\Partner;

use Backend\Modules\Partners\Domain\Widget\Widget;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="PartnersPartner")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
final class Partner
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var Image
     *
     * @ORM\Column(type="partners_partner_image")
     */
    private $image;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    private $url;

    /**
     * @var Widget
     *
     * @ORM\ManyToOne(targetEntity="Backend\Modules\Partners\Domain\Widget\Widget", inversedBy="partners")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    private $widget;

    /**
     * @param Image $image
     * @param string $name
     * @param string $url
     */
    public function __construct(Widget $widget, Image $image, $name, $url)
    {
        $this->widget = $widget;
        $this->image = $image;
        $this->name = $name;
        $this->url = $url;
    }

    /**
     * @param Image $image
     * @param string $name
     * @param string $url
     */
    public function update(Image $image, $name, $url)
    {
        $this->image = $image;
        $this->name = $name;
        $this->url = $url;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Image
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function prepareToUploadImage()
    {
        if (!$this->image instanceof Image) {
            return;
        }

        $this->image->prepareToUpload();
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function uploadImage()
    {
        if (!$this->image instanceof Image) {
            return;
        }

        $this->image->upload();
    }

    /**
     * @ORM\PostRemove()
     */
    public function removeImage()
    {
        if (!$this->image instanceof Image) {
            return;
        }

        $this->image->remove();
    }

    /**
     * @param PartnerDataTransferObject $partnerDataTransferObject
     * @param Widget|null $widget
     *
     * @return Partner
     */
    public static function fromDataTransferObject(
        PartnerDataTransferObject $partnerDataTransferObject,
        Widget $widget = null
    ) {
        if ($partnerDataTransferObject->hasExistingPartner()) {
            $partner = $partnerDataTransferObject->getPartnerEntity();

            $partner->image = $partnerDataTransferObject->image;
            $partner->name = $partnerDataTransferObject->name;
            $partner->url = $partnerDataTransferObject->url;

            return $partner;
        }

        $partner = new self(
            $widget,
            $partnerDataTransferObject->image,
            $partnerDataTransferObject->name,
            $partnerDataTransferObject->url
        );

        return $partner;
    }
}
