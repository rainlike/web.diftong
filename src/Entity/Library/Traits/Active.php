<?php
declare(strict_types=1);

namespace App\Entity\Library\Traits;

/**
 * Trait Active
 *
 * @package App\Entity\Library\Traits
 * @author Alexander Saveliev <alex@spbcrew.com>
 */
trait Active
{
    /**
     * @var bool
     * @ORM\Column(name="active", type="boolean", nullable=true, unique=false)
     */
    private $active;

    /**
     * Set active
     *
     * @param bool $active
     * @return self
     */
    public function setActive(bool $active = true): self
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return bool|null
     */
    public function getActive(): ?bool
    {
        return $this->active;
    }
}
