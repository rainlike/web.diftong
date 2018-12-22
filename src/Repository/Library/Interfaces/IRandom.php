<?php
/**
 * ILast Interface
 * Marks repositories which should has method getting random record
 *
 * @package App\Repository\Library\Interfaces
 * @version 1.0.0
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @copyright 2018 spbcrew.com (https://www.spbcrew.com)
 * @author Alexander Saveliev <alex@spbcrew.com>
 */
declare(strict_types=1);

namespace App\Repository\Library\Interfaces;

use App\Entity\Library\Interfaces\IRandomly;

/** Interface IRandom */
interface IRandom
{
    /**
     * Get random record
     *
     * @return IRandomly|null
     */
    public function getRandom();
}
