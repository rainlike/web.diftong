<?php
/**
 * Interface IUltimateUri
 * Marks entities as which have method for generate ultimate URI
 *
 * @package App\Entity\Library\Interfaces
 * @version 1.0.0
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @copyright 2018 spbcrew.com (https://www.spbcrew.com)
 * @author Alexander Saveliev <alex@spbcrew.com>
 */
declare(strict_types=1);

namespace App\Entity\Library\Interfaces;

/** Interface IUltimateUri */
interface IUltimateUri
{
    /**
     * Get ultimate URI
     *
     * @return string|null
     */
    public function getUltimateUri(): ?string;
}
