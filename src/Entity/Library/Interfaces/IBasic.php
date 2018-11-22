<?php
declare(strict_types=1);

namespace App\Entity\Library\Interfaces;

use App\Entity\Library\Traits\Enabled;
use App\Entity\Library\Traits\Created;
use App\Entity\Library\Traits\Updated;

/**
 * Interface IBasic
 *
 * @package App\Entity\Library\Interfaces
 * @author Alexander Saveliev <alex@spbcrew.com>
 */
interface IBasic
{
    /**
     * Get id
     *
     * @return int|null
     */
    public function getId(): ?int;

    /**
     * Set enabled
     *
     * @param bool $enabled
     * @return Enabled|self
     */
    public function setEnabled(bool $enabled = true);

    /**
     * Get enabled
     *
     * @return bool|null
     */
    public function getEnabled(): ?bool;

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Created|self
     */
    public function setCreated(\DateTime $created);

    /**
     * Get created
     *
     * @return \DateTime|null
     */
    public function getCreated(): ?\DateTime;

    /**
     * Set updated
     *
     * @param \DateTime $updated
     * @return Updated|self
     */
    public function setUpdated(\DateTime $updated);

    /**
     * Get updated
     *
     * @return \DateTime|null
     */
    public function getUpdated(): ?\DateTime;

    /**
     * Get pure class name
     *
     * @return string
     */
    public function getClassName(): string;
}
