<?php
declare(strict_types=1);

namespace App\Entity\Library\Interfaces;

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

    # @TODO
    # EnabledField
    # CreatedField
    # UpdatedField

    /**
     * Get pure class name
     *
     * @return string
     */
    public function getClassName(): string;
}
