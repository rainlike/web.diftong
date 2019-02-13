<?php
declare(strict_types=1);

namespace App\Entity\Library\Interfaces;

use App\Entity\ValueType;

/**
 * Interface ISetting
 *
 * @package App\Entity\Library\Interfaces
 * @author Alexander Saveliev <me@rainlike.com>
 */
interface ISetting
{
    /**
     * Set type
     *
     * @param ValueType $type
     * @return ISetting
     */
    public function setType(ValueType $type);

    /**
     * Get type
     *
     * @return ValueType|null
     */
    public function getType(): ?ValueType;

    /**
     * Set value
     *
     * @param string $value
     * @return ISetting
     */
    public function setValue(string $value);

    /**
     * Get value
     *
     * @return string|null
     */
    public function getValue(): ?string;
}
