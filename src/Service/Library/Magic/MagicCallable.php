<?php
/**
 * MagicCallable Trait
 * Provides magic __call() method for Service
 * It allows to use classic methods as static
 *
 * @package App\Repository\Library\Traits
 * @version 1.0.0
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @copyright 2018 spbcrew.com (https://www.spbcrew.com)
 * @author Alexander Saveliev <alex@spbcrew.com>
 */
declare(strict_types=1);

namespace App\Service\Library\Magic;

use Symfony\Component\Debug\Exception\UndefinedMethodException;

use App\Utility\StaticCodes;

/** Trait MagicCallable */
trait MagicCallable
{
    /**
     * Magic __call method
     *
     * @param string $method
     * @param array $arguments
     * @return mixed
     * @throws UndefinedMethodException
     */
    public function __call($method, $arguments)
    {
        $isExists = \method_exists($this, $method);
        if ($isExists) {
            return self::$method(...$arguments);
        }

        throw new UndefinedMethodException(
            StaticCodes::EXCEPTION_UNDEFINED_METHOD_MESSAGE,
            new \ErrorException()
        );
    }
}
