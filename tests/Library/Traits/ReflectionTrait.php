<?php
declare(strict_types=1);

namespace App\Tests\Library\Traits;

/**
 * Trait ReflectionTrait
 *
 * @package App\Tests\Library\Traits
 * @author Alexander Saveliev <alex@spbcrew.com>
 */
trait ReflectionTrait
{
    /** @var string */
    protected $target;

    /**
     * Get reflection of class
     *
     * @param string|null $literal
     * @return \ReflectionClass
     * @throws \ReflectionException
     */
    protected function reflection(?string $literal = null): \ReflectionClass
    {
        return new \ReflectionClass($literal ?: $this->target);
    }

    /**
     * Get protected method marked as accessible
     *
     * @param string $name
     * @param string|null $literal
     * @return \ReflectionMethod
     * @throws \ReflectionException
     */
    protected function reflectionMethod(string $name, string $literal = null): \ReflectionMethod
    {
        $refClass = new \ReflectionClass($literal ?: $this->target);
        $method = $refClass->getMethod($name);
        $method->setAccessible(true);

        return $method;
    }

    /**
     * Get protected property marked as accessible
     *
     * @param string $name
     * @param string|null $literal
     * @return \ReflectionProperty
     * @throws \ReflectionException
     */
    protected function reflectionProperty(string $name, string $literal = null): \ReflectionProperty
    {
        $refClass = new \ReflectionClass($literal ?: $this->target);
        $property = $refClass->getProperty($name);
        $property->setAccessible(true);

        return $property;
    }
}
