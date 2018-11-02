<?php
declare(strict_types=1);

namespace App\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trait Enabled
 *
 * @package App\Entity\Traits
 * @author Alexander Saveliev <alex@spbcrew.com>
 */
trait Enabled
{
    /**
     * @var bool
     * @ORM\Column(name="enabled", type="boolean", nullable=true, unique=false)
     */
    private $enabled;

    /**
     * Set enabled
     *
     * @param bool $enabled
     * @return self
     */
    public function setEnabled(bool $enabled = true): self
    {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * Get enabled
     *
     * @return bool|null
     */
    public function getEnabled(): ?bool
    {
        return $this->enabled;
    }
}
