<?php
/**
 * Cleanup Interface
 * Marks command as has cleanup methods
 *
 * @package App\Command\Library\Interfaces
 * @version 1.0.0
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @copyright 2018 diftong.com (https://www.diftong.com)
 * @author Alexander Saveliev <me@rainlike.com>
 */
declare(strict_types=1);

namespace App\Command\Library\Interfaces;

/** Interface ICleanup */
interface ICleanup
{
    /**
     * Cleanup internal variables
     */
    public function cleanUp(): void;
}
