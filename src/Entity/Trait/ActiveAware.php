<?php declare(strict_types=1);

namespace App\Entity\Trait;

use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Common\Collections\Selectable;
use Doctrine\ORM\Mapping as ORM;

trait ActiveAware
{
    #[ORM\Column]
    protected bool $active = true;

    public static function filterActive(Collection $collection, bool $active = true): Collection
    {
        assert($collection instanceof Selectable);

        $criteria = Criteria::create()
            ->andWhere(Criteria::expr()->eq('active', $active));

        return $collection->matching($criteria);
    }

    public function toggleActive(): self
    {
        $this->setActive(!$this->isActive());

        return $this;
    }

    public function isActive(): bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;

        return $this;
    }
}
