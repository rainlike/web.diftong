<?php
declare(strict_types=1);

namespace App\Repository\Library\Traits;

use Symfony\Component\Debug\Exception\UndefinedMethodException;

use App\Utility\StaticCodes;

/**
 * Trait MagicCallable
 *
 * @package App\Repository\Library\Traits
 * @author Alexander Saveliev <alex@spbcrew.com>
 */
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
            return $this->$method(...$arguments);
        }

        if (0 === \strpos($method, 'findBy')
            || 0 === strpos($method, 'findOneBy')
            || 0 === strpos($method, 'countBy')
        ) {
            return parent::__call($method, $arguments);
        }

        $queryMethod = $method.'Query';
        if ($queryMethod) {
            return $this->$queryMethod(...$arguments)->getResult();
        }

        throw new UndefinedMethodException(StaticCodes::EXCEPTION_UNDEFINED_METHOD_MESSAGE, new \ErrorException());
    }
}
