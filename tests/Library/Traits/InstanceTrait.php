<?php
declare(strict_types=1);

namespace App\Tests\Library\Traits;

/**
 * Trait InstanceTrait
 *
 * @package App\Tests\Library\Traits
 * @author Alexander Saveliev <alex@spbcrew.com>
 */
trait InstanceTrait
{
    /** @var string */
    protected $target;

    /**
     * Get instance of class
     *
     * @param string|null $literal
     * @param array|null $parameters
     * @return object
     */
    protected function instance(?string $literal = null, ?array $parameters = null): object
    {
        $literal = $literal ?: $this->target;
        $reflection = $parameters
            ? new $literal(...$parameters)
            : new $literal();

        return $reflection;
    }
}
