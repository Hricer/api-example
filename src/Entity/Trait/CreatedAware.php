<?php declare(strict_types=1);

namespace App\Entity\Trait;

use DateTime;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

trait CreatedAware
{
    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Gedmo\Timestampable(on: 'create')]
    protected null|DateTime $createdAt = null;

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }
}
