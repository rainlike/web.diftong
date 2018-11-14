<?php
declare(strict_types=1);

namespace App\Tests\Utility;

use PHPUnit\Framework\TestCase;

use App\Utility\StaticLibrary as Target;

/**
 * Class StaticLibraryTest
 *
 * @package App\Tests\Utility
 */
class StaticLibraryTest extends TestCase
{
    /**
     * Test `slug` static method
     *
     * @param array $data
     * @param string|null $expected
     * @return void
     * @group utility
     * @group done
     * @dataProvider slugProvider
     */
    public function testSlug(array $data, ?string $expected = null): void
    {
        Target::$slug_delimiter = $data['delimiter'];

        $result = Target::slug(...$data['args']);

        $this->assertEquals($expected, $result);
    }

    /**
     * Data for testSlug
     *
     * @return array
     */
    public function slugProvider(): array
    {
        return [
            'blank case' => [
                'data' => [
                    'args' => [],
                    'delimiter' => '-'
                ],
                'expected' => '',
            ],
            'single item case' => [
                'data' => [
                    'args' => ['single'],
                    'delimiter' => '-'
                ],
                'expected' => 'single'
            ],
            'separated single case' => [
                'data' => [
                    'args' => ['separated single'],
                    'delimiter' => '-'
                ],
                'expected' => 'separated-single'
            ],
            'separated single case with non default delimiter' => [
                'data' => [
                    'args' => ['separated single'],
                    'delimiter' => '_'
                ],
                'expected' => 'separated_single'
            ],
            'array case' => [
                'data' => [
                    'args' => ['first', 'second', 'third'],
                    'delimiter' => '-'
                ],
                'expected' => 'first-second-third'
            ],
            'array case with combined element' => [
                'data' => [
                    'args' => ['first', 'combined second', 'third'],
                    'delimiter' => '+'
                ],
                'expected' => 'first+combined+second+third'
            ]
        ];
    }

    /**
     * Test `lastChar` static method
     *
     * @param string $data
     * @param string $expected
     * @return void
     * @group utility
     * @group done
     * @dataProvider lastCharProvider
     */
    public function testLastChar(string $data, string $expected): void
    {

        $result = Target::lastChar($data);

        $this->assertEquals($expected, $result);
    }

    /**
     * Data for testLastChar
     *
     * @return array
     */
    public function lastCharProvider(): array
    {
        return [
            'first case' => [
                'data' => 'first',
                'expected' => 't'
            ],
            'second case' => [
                'data' => 'second',
                'expected' => 'd'
            ],
            'third case' => [
                'data' => 'third',
                'expected' => 'd'
            ]
        ];
    }
}
