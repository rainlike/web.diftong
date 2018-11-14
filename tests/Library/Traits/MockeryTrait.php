<?php
declare(strict_types=1);

namespace App\Tests\Library\Traits;

use \Mockery;
use \Mockery\MockInterface;

/**
 * Trait MockeryTrait
 *
 * @package App\Tests\Library\Traits
 * @author Alexander Saveliev <alex@spbcrew.com>
 */
trait MockeryTrait
{
    /** @var string */
    protected $target;

    /**
     * Get mock of class
     *
     * @param null|string $literal
     * @return MockInterface
     */
    protected function mockery(string $literal = null): MockInterface
    {
        return Mockery::mock($literal ?: $this->target);
    }
}
