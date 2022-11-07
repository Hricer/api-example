<?php declare(strict_types=1);

namespace App\Entity\Trait;

use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Common\Collections\Selectable;
use Doctrine\ORM\Mapping as ORM;

trait RemovedAware
{
    #[ORM\Column]
    protected bool $removed = false;

    public static function filterRemoved(Collection $collection, bool $removed = false): Collection
    {
        assert($collection instanceof Selectable);

        $criteria = Criteria::create()
            ->andWhere(Criteria::expr()->eq('removed', $removed));

        return $collection->matching($criteria);
    }

    public function isRemoved(): bool
    {
        return $this->removed;
    }

    public function setRemoved(): self
    {
        $this->removed = true;

        return $this;
    }
}
