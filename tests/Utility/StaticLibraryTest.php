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

    /**
     * Test `randomString` static method
     *
     * @return void
     * @throws \Exception
     * @group utility
     * @group done
     */
    public function testRandomString(): void
    {
        $lengths = [3, 5, 8, 13, 21];

        foreach ($lengths as $length) {
            $result = Target::randomString($length);

            $this->assertInternalType('string', $result);
            $this->assertEquals($length, \strlen($result));
        }
    }

    /**
     * Test `underscoreToCamelCase` static method
     *
     * @param string $data
     * @param bool $capitalize
     * @param string $expected
     * @return void
     * @group utility
     * @group done
     * @dataProvider snakeToCamelCaseProvider
     */
    public function testSnakeToCamelCase(string $data, bool $capitalize, string $expected): void
    {
        $result = Target::snakeToCamelCase($data, $capitalize);

        $this->assertEquals($expected, $result);
    }

    /**
     * Data for testSnakeToCamelCase
     *
     * @return array
     */
    public function snakeToCamelCaseProvider(): array
    {
        return [
            'single world non capitalize case' => [
                'data' => 'solid',
                'capitalize' => false,
                'expected' => 'solid'
            ],
            'single world capitalize case' => [
                'data' => 'solid',
                'capitalize' => true,
                'expected' => 'Solid'
            ],
            'correct string non capitalize case' => [
                'data' => 'string_with_snakes',
                'capitalize' => false,
                'expected' => 'stringWithSnakes'
            ],
            'correct string capitalize case' => [
                'data' => 'string_with_snakes',
                'capitalize' => true,
                'expected' => 'StringWithSnakes'
            ]
        ];
    }

    /**
     * Test `camelToSnakeCase` static method
     *
     * @param string $data
     * @param string $expected
     * @return void
     * @group utility
     * @group done
     * @dataProvider camelToSnakeCaseProvider
     */
    public function testCamelToSnakeCase(string $data, string $expected): void
    {
        $result = Target::camelToSnakeCase($data);

        $this->assertEquals($expected, $result);
    }

    /**
     * Data for testCamelToSnakeCase
     *
     * @return array
     */
    public function camelToSnakeCaseProvider(): array
    {
        return [
            'single world case' => [
                'data' => 'solid',
                'expected' => 'solid'
            ],
            'single capitalized world case' => [
                'data' => 'Solid',
                'expected' => 'solid'
            ],
            'correct string non capitalized case' => [
                'data' => 'stringWithCamels',
                'expected' => 'string_with_camels'
            ],
            'correct string capitalized case' => [
                'data' => 'StringWithCamels',
                'expected' => 'string_with_camels'
            ]
        ];
    }

    /**
     * Test `startWith` static method
     *
     * @param string $data
     * @param string $expected
     * @param string $start
     * @return void
     * @group utility
     * @group done
     * @dataProvider startWithProvider
     */
    public function testStartWith(string $data, string $expected, string $start): void
    {
        $result = Target::startWith($data, $start);

        $this->assertEquals($expected, $result);
    }

    /**
     * Data for testStartWith
     *
     * @return array
     */
    public function startWithProvider(): array
    {
        return [
            'first case' => [
                'data' => 'lorem ipsum',
                'expected' => true,
                'start' => 'lor'
            ],
            'second case' => [
                'data' => 'lorem ipsum',
                'expected' => true,
                'start' => 'lorem'
            ],
            'third case' => [
                'data' => 'lorem ipsum',
                'expected' => true,
                'start' => 'lorem i'
            ],
            'incorrect case' => [
                'data' => 'lorem ipsum',
                'expected' => false,
                'start' => 'ips'
            ]
        ];
    }

    /**
     * Test `upFirstChar` static method
     *
     * @param string $data
     * @param string $expected
     * @return void
     * @group utility
     * @group done
     * @dataProvider upFirstCharProvider
     */
    public function testUpFirstChar(string $data, string $expected): void
    {
        $result = Target::upFirstChar($data);

        $this->assertEquals($expected, $result);
    }

    /**
     * Data for testUpFirstChar
     *
     * @return array
     */
    public function upFirstCharProvider(): array
    {
        return [
            'first case' => [
                'data' => 'lower',
                'expected' => 'Lower'
            ],
            'second case' => [
                'data' => 'Upper',
                'expected' => 'Upper'
            ],
            'digit case' => [
                'data' => '5 dollars',
                'expected' => '5 dollars'
            ]
        ];
    }

    /**
     * Test `findStringPlaceholders` static method
     *
     * @param array $data
     * @param int|array|null $expected
     * @return void
     * @throws \Exception
     * @group utility
     * @group done
     * @dataProvider findStringPlaceholdersProvider
     */
    public function testFindStringPlaceholders(array $data, $expected): void
    {
        $result = Target::findStringPlaceholders(...$data);

        $this->assertEquals($expected, $result);
    }

    /**
     * Data for testFindStringPlaceholders
     *
     * @return array
     */
    public function findStringPlaceholdersProvider(): array
    {
        $testedString = 'tested_%placeholder%_string';
        $testedDescriptors = ['%', '%'];

        return [
            'default case' => [
                'data' => [$testedString, $testedDescriptors, null, false],
                'expected' => ['placeholder']
            ],
            'default case with handling' => [
                'data' => [$testedString, $testedDescriptors, null, true],
                'expected' => []
            ],
            'flag clean case' => [
                'data' => [$testedString, $testedDescriptors, Target::$flag_string_placeholders_clean, false],
                'expected' => ['placeholder']
            ],
            'flag framed case' => [
                'data' => [$testedString, $testedDescriptors, Target::$flag_string_placeholders_framed, false],
                'expected' => ['%placeholder%']
            ],
            'flag all case' => [
                'data' => [$testedString, $testedDescriptors, Target::$flag_string_placeholders_all, false],
                'expected' => [['%placeholder%'], ['placeholder']]
            ],
            'flag count case' => [
                'data' => [$testedString, $testedDescriptors, Target::$flag_string_placeholders_count, false],
                'expected' => 1
            ],
            'incorrect placeholders case' => [
                'data' => [$testedString, ['%', '#'], null, false],
                'expected' => []
            ]
        ];
    }
}
