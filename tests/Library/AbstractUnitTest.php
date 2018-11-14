<?php
declare(strict_types=1);

namespace App\Tests\Library;

use PHPUnit\Framework\TestCase;

use App\Tests\Library\Traits\MockTrait;
use App\Tests\Library\Traits\MockeryTrait;
use App\Tests\Library\Traits\InstanceTrait;
use App\Tests\Library\Traits\ReflectionTrait;

/**
 * Class AbstractUnitTest
 *
 * @package App\Tests\Library
 */
abstract class AbstractUnitTest extends TestCase
{
    use MockTrait;
    use MockeryTrait;
    use InstanceTrait;
    use ReflectionTrait;

    /** @var string */
    protected $target;

    /**
     * AbstractUnitTest constructor
     *
     * @param null|string $name
     * @param array $data
     * @param string $dataName
     */
    public function __construct(?string $name = null, array $data = [], string $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->setTargetPath();
    }

    /**
     * Calls after each test
     *
     * @return void
     */
    protected function setUp(): void {}

    /**
     * Calls before each test
     *
     * @return void
     */
    protected function tearDown(): void {}

    /**
     * Set path of tested class
     *
     * @return void
     */
    protected function setTargetPath(): void
    {
        $testPath = static::class;
        $targetPath = \str_replace('Tests\\', '', \preg_replace('/Test$/', '', $testPath));

        $this->target = $targetPath;
    }
}
