<?php
declare(strict_types=1);

namespace App\Tests\Library\Traits;

/**
 * Trait MockTrait
 *
 * @package App\Tests\Library\Traits
 * @author Alexander Saveliev <alex@spbcrew.com>
 */
trait MockTrait
{
    /** @var string */
    protected $target;

    /**
     * Get mock of class
     *
     * @param array $parameters
     * @param null|string $literal
     * @return object
     * @throws \Exception
     */
    protected function mock(array $parameters = [], ?string $literal = null): object
    {
        return $this->createMock($literal ?: $this->target,
            $parameters
        );
    }
}
