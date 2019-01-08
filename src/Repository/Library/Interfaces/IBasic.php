<?php
declare(strict_types=1);

namespace App\Repository\Library\Interfaces;

/**
 * Class IBasic
 *
 * @package App\Repository\Library\Interfaces
 * @author Alexander Saveliev <alex@spbcrew.com>
 */
interface IBasic extends IEnabled, IColumns
{
    /**
     * Magic __call method
     *
     * @param string $method
     * @param array $arguments
     * @return mixed
     */
    public function __call($method, $arguments);
}
