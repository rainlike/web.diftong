<?php
declare(strict_types=1);

namespace App\Tests\Utility;

use App\Tests\Library\AbstractUnitTest;

use App\Utility\StaticLibrary as Target;

use App\Entity\Portal;

/**
 * Class StaticLibraryTest
 *
 * @package App\Tests\Utility
 */
class StaticLibraryTest extends AbstractUnitTest
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

    /**
     * Test private `stringPlaceholdersHandle` private static method
     *
     * @param array $data
     * @param array $expected
     * @return void
     * @throws \Exception
     * @group utility
     * @group done
     * @dataProvider stringPlaceholdersHandleProvider
     */
    public function testStringPlaceholdersHandle(array $data, array $expected): void
    {
        $assertExpected = [
            $expected['processed_string'],
            $expected['processed_descriptors'],
            $expected['failed']
        ];

        $method = $this->reflectionMethod('stringPlaceholdersHandle');

        $result = $method->invoke(null, ...$data);

        $this->assertEquals($assertExpected, $result);
    }

    /**
     * Data for testStringPlaceholdersHandle
     *
     * @return array
     */
    public function stringPlaceholdersHandleProvider(): array
    {
        $testedString = 'tested_%placeholder%_string';
        $testedDescriptors = ['%', '%'];

        return [
            'without descriptors case' => [
                'data' => [$testedString, false],
                'expected' => [
                    'processed_string' => $testedString,
                    'processed_descriptors' => Target::$string_placeholders_default_descriptors,
                    'failed' => false
                ]
            ],
            'with descriptors case' => [
                'data' => [$testedString, false, $testedDescriptors],
                'expected' => [
                    'processed_string' => $testedString,
                    'processed_descriptors' => $testedDescriptors,
                    'failed' => false
                ]
            ],
            'without descriptors failed case' => [
                'data' => [$testedString, true],
                'expected' => [
                    'processed_string' => $testedString,
                    'processed_descriptors' => Target::$string_placeholders_default_descriptors,
                    'failed' => true
                ]
            ],
            'with descriptors with handling case' => [
                'data' => [$testedString, true, $testedDescriptors],
                'expected' => [
                    'processed_string' => \str_replace($testedDescriptors, Target::$string_placeholders_default_descriptors, $testedString),
                    'processed_descriptors' => Target::$string_placeholders_default_descriptors,
                    'failed' => false
                ]
            ],
            'no any descriptors case' => [
                'data' => [$testedString, false],
                'expected' => [
                    'processed_string' => $testedString,
                    'processed_descriptors' => ['{{', '}}'],
                    'failed' => false
                ]
            ],
            'with descriptors without handling case' => [
                'data' => [$testedString, false, $testedDescriptors],
                'expected' => [
                    'processed_string' => $testedString,
                    'processed_descriptors' => $testedDescriptors,
                    'failed' => false
                ]
            ]
        ];
    }

    /**
     * Test `isValidDescriptors` private static method
     *
     * @param array $data
     * @param bool $expected
     * @return void
     * @throws \Exception
     * @group utility
     * @group done
     * @dataProvider isValidDescriptorsProvider
     */
    public function testIsValidDescriptors(array $data, bool $expected): void
    {
        $method = $this->reflectionMethod('isValidDescriptors');

        $result = $method->invoke(null, $data);

        $this->assertEquals($expected, $result);
    }

    /**
     * Data for testIsValidDescriptors
     *
     * @return array
     */
    public function isValidDescriptorsProvider(): array
    {
        return [
            'valid descriptors case' => [
                'data' => ['%', '%'],
                'expected' => true
            ],
            'incorrect count of descriptors case' => [
                'data' => ['%', '%', '%'],
                'expected' => false
            ],
            'incorrect types of descriptors case' => [
                'data' => ['%', 1],
                'expected' => false
            ]
        ];
    }

    /**
     * Test `simpleArrayShift` static method
     *
     * @param array $data
     * @param array $expected
     * @return void
     * @group utility
     * @group done
     * @dataProvider arraySimpleShiftProvider
     */
    public function testSimpleArrayShift(array $data, array $expected): void
    {
        $result = Target::simpleArrayShift($data);

        $this->assertEquals($expected, $result);
    }

    /**
     * Data for testSimpleArrayShift
     *
     * @return array
     */
    public function arraySimpleShiftProvider(): array
    {
        return [
            'simple case' => [
                'data' => [0, 1, 2, 3, 4, 5],
                'expected' => [1, 2, 3, 4, 5]
            ]
        ];
    }

    /**
     * Test `arrayShift` static method
     *
     * @param array $data
     * @param array $expected
     * @param int $count
     * @return void
     * @group utility
     * @group done
     * @dataProvider arrayShiftProvider
     */
    public function testArrayShift(array $data, array $expected, ?int $count = null): void
    {
        $result = Target::arrayShift($data, $count);

        $this->assertEquals($expected, $result);
    }

    /**
     * Data for testArrayShift
     *
     * @return array
     */
    public function arrayShiftProvider(): array
    {
        return [
            'null count case' => [
                'data' => [0, 1, 2, 3, 4, 5],
                'expected' => [1, 2, 3, 4, 5],
                'count' => null
            ],
            '0 count case' => [
                'data' => [0, 1, 2, 3, 4, 5],
                'expected' => [0, 1, 2, 3, 4, 5],
                'count' => 0
            ],
            '1 count case' => [
                'data' => [0, 1, 2, 3, 4, 5],
                'expected' => [1, 2, 3, 4, 5],
                'count' => 1
            ],
            '2 count case' => [
                'data' => [0, 1, 2, 3, 4, 5],
                'expected' => [2, 3, 4, 5],
                'count' => 2
            ],
            'pre max count case' => [
                'data' => [0, 1, 2, 3, 4, 5],
                'expected' => [5],
                'count' => 5
            ],
            'max count case' => [
                'data' => [0, 1, 2, 3, 4, 5],
                'expected' => [],
                'count' => 6
            ],
            'negative count case' => [
                'data' => [0, 1, 2, 3, 4, 5],
                'expected' => [1, 2, 3, 4, 5],
                'count' => -1
            ]
        ];
    }

    /**
     * Test `isSequentialArray` static method
     *
     * @param array $data
     * @param bool $expected
     * @return void
     * @group utility
     * @group done
     * @dataProvider isSequentialArrayProvider
     */
    public function testIsSequentialArray(array $data, bool $expected): void
    {
        $result = Target::isSequentialArray($data);

        $this->assertEquals($expected, $result);
    }

    /**
     * Data for testIsSequentialArray
     *
     * @return array
     */
    public function isSequentialArrayProvider(): array
    {
        return [
            'numeric case' => [
                'data' => [0, 1, 2, 3],
                'expected' => true
            ],
            'strings case' => [
                'data' => ['lorem', 'ipsum'],
                'expected' => true
            ],
            'arrays case' => [
                'data' => [[], []],
                'expected' => true
            ],
            'different types case' => [
                'data' => [1, 'lorem ipsum'],
                'expected' => true
            ],
            'incorrect case' => [
                'data' => [
                    'lorem' => 'lorem',
                    'ipsum' => 'ipsum'
                ],
                'expected' => false
            ]
        ];
    }

    /**
     * Test `isAssociativeArray` static method
     *
     * @param array $data
     * @param bool $expected
     * @return void
     * @group utility
     * @group done
     * @dataProvider isAssociativeArrayProvider
     */
    public function testIsAssociativeArray(array $data, bool $expected): void
    {
        $result = Target::isAssociativeArray($data);

        $this->assertEquals($expected, $result);
    }

    /**
     * Data for testIsAssociativeArray
     *
     * @return array
     */
    public function isAssociativeArrayProvider(): array
    {
        return [
            'correct case' => [
                'data' => [
                    'lorem' => 'lorem',
                    'ipsum' => 'ipsum'
                ],
                'expected' => true
            ],
            'incorrect case' => [
                'data' => ['lorem', 'ipsum'],
                'expected' => false
            ]
        ];
    }

    /**
     * Test `arrayType` static method
     *
     * @param array $data
     * @param int|string $expected
     * @return void
     * @group utility
     * @group done
     * @dataProvider arrayTypeProvider
     */
    public function testArrayType(array $data, $expected): void
    {
        $result = Target::arrayType(...$data);

        $this->assertEquals($expected, $result);
    }

    /**
     * Data for testArrayType
     *
     * @return array
     */
    public function arrayTypeProvider(): array
    {
        return [
            'string array case' => [
                'data' => [['a', 'b', 'c'], null],
                'expected' => 'sequential'
            ],
            'numeric array case' => [
                'data' => [[1, 2, 3], null],
                'expected' => 'sequential'
            ],
            'associative array case' => [
                'data' => [[
                    'a' => 1,
                    'b' => 2
                ], null],
                'expected' => 'associative'
            ],
            'numeric flag case' => [
                'data' => [[1, 2, 3], Target::$flag_array_type_numeric],
                'expected' => 2
            ],
            'numeric flag associative array case' => [
                'data' => [[
                    'a' => 1,
                    'b' => 2
                ], Target::$flag_array_type_numeric],
                'expected' => 1
            ]
        ];
    }

    /**
     * Test `arrayKeysExists` static method
     *
     * @param array $data
     * @param bool $expected
     * @return void
     * @group utility
     * @group done
     * @dataProvider arrayKeysExistsProvider
     */
    public function testArrayKeysExists(array $data, bool $expected): void
    {
        $result = Target::arrayKeysExists(...$data);

        $this->assertEquals($expected, $result);
    }

    /**
     * Data for testArrayKeysExists
     *
     * @return array
     */
    public function arrayKeysExistsProvider(): array
    {
        $targetArray = [
            'a' => 2,
            'b' => 3,
            'c' => 5
        ];

        return [
            'incorrect $keys argument type case' => [
                'data' => [false, []],
                'expected' => false
            ],
            'associative $keys case' => [
                'data' => [[
                    'a' => 1,
                    'b' => 2
                ], []],
                'expected' => false
            ],
            'simple string key case' => [
                'data' => ['a', $targetArray, false],
                'expected' => true
            ],
            'simple array keys case' => [
                'data' => [['a'], $targetArray, false],
                'expected' => true
            ],
            'full coincidence case' => [
                'data' => [['a', 'b', 'c'], $targetArray, true],
                'expected' => true
            ]
        ];
    }

    /**
     * Test `arrayExcept` static method
     *
     * @param array $data
     * @param array $expected
     * @return void
     * @group utility
     * @group done
     * @dataProvider arrayExceptProvider
     */
    public function testArrayExcept(array $data, array $expected): void
    {
        $result = Target::arrayExcept(...$data);

        $this->assertEquals($expected, $result);
    }

    /**
     * Data for testArrayExcept
     *
     * @return array
     */
    public function arrayExceptProvider(): array
    {
        $sourceArray = ['a', 'b', 'c'];

        return [
            'associative $excepts case' => [
                'data' => [$sourceArray, ['lorem' => 'ipsum']],
                'expected' => $sourceArray
            ],
            'first simple case' => [
                'data' => [$sourceArray, ['a']],
                'expected' => ['b', 'c']
            ],
            'second simple case' => [
                'data' => [$sourceArray, ['a', 'c']],
                'expected' => ['b']
            ],
            'associative array case' => [
                'data' => [[
                    'a' => 'aaa',
                    'b' => 'bbb',
                    'c' => 'ccc'
                ], ['a', 'c']],
                'expected' => [
                    'b' => 'bbb'
                ]
            ]
        ];
    }

    /**
     * Test `arrayHasOnlyTypes` static method
     *
     * @param array $data
     * @param bool|null $expected
     * @return void
     * @group utility
     * @group done
     * @dataProvider arrayHasOnlyTypesProvider
     */
    public function testArrayHasOnlyTypes(array $data, ?bool $expected = null): void
    {
        $result = Target::arrayHasOnlyTypes(...$data);

        $this->assertEquals($expected, $result);
    }

    /**
     * Data for testArrayHasOnlyTypes
     *
     * @return array
     */
    public function arrayHasOnlyTypesProvider(): array
    {
        return [
            'incorrect type case' => [
                'data' => [[2, 3, 5], 'fake'],
                'expected' => null
            ],
            'integer type case' => [
                'data' => [[2, 3, 5], 'integer'],
                'expected' => true
            ],
            'string type case' => [
                'data' => [['lorem', 'ipsum'], 'string'],
                'expected' => true
            ],
            'array type case' => [
                'data' => [[[], [], []], 'array'],
                'expected' => true
            ],
            'negative case' => [
                'data' => [[2, 3, 5, 'lorem ipsum'], 'array'],
                'expected' => false
            ]
        ];
    }

    /**
     * Test `transformToSequentialArray` static method
     *
     * @param array $data
     * @param array $expected
     * @return void
     * @group utility
     * @group done
     * @dataProvider transformToSequentialArrayProvider
     */
    public function testTransformToSequentialArray(array $data, array $expected): void
    {
        $result = Target::transformToSequentialArray(...$data);

        $this->assertEquals($expected, $result);
    }

    /**
     * Data for testTransformToSequentialArray
     *
     * @return array
     */
    public function transformToSequentialArrayProvider(): array
    {
        return [
            'sequential array case' => [
                'data' => [['a', 'b', 'c'], '-'],
                'expected' => ['a', 'b', 'c']
            ],
            'correct case' => [
                'data' => [[
                    'a' => 'aaa',
                    'b' => 'bbb',
                    'c' => 'ccc'
                ], '-'],
                'expected' => [
                    'a-aaa',
                    'b-bbb',
                    'c-ccc'
                ]
            ]
        ];
    }

    /**
     * Test `transformToAssociativeArray` static method
     *
     * @param array $data
     * @param array $expected
     * @return void
     * @group utility
     * @group done
     * @dataProvider transformToAssociativeArrayProvider
     */
    public function testTransformToAssociativeArray(array $data, array $expected): void
    {
        $result = Target::transformToAssociativeArray($data);

        $this->assertEquals($expected, $result);
    }

    /**
     * Data for testTransformToAssociativeArray
     *
     * @return array
     */
    public function transformToAssociativeArrayProvider(): array
    {
        return [
            'associative array case' => [
                'data' => [
                    'a' => 'aaa',
                    'b' => 'bbb',
                    'c' => 'ccc'
                ],
                'expected' => [
                    'a' => 'aaa',
                    'b' => 'bbb',
                    'c' => 'ccc'
                ]
            ],
            'correct case' => [
                'data' => ['a', 'b', 'c'],
                'expected' => [
                    'a' => 'a',
                    'b' => 'b',
                    'c' => 'c'
                ]
            ]
        ];
    }

    /**
     * Test `isMaterialArray` static method
     *
     * @param array $data
     * @param bool $expected
     * @return void
     * @group utility
     * @group done
     * @dataProvider isMaterialArrayProvider
     */
    public function testIsMaterialArray(array $data, bool $expected): void
    {
        $result = Target::isMaterialArray(...$data);

        $this->assertEquals($expected, $result);
    }

    /**
     * Data for testIsMaterialArray
     *
     * @return array
     */
    public function isMaterialArrayProvider(): array
    {
        return [
            'full material numeric array case' => [
                'data' => [[2, 3, 5], null, false, false],
                'expected' => true
            ],
            'full material numeric array case with 0' => [
                'data' => [[0, 1, 1, 2, 3, 5], null, false, false],
                'expected' => true
            ],
            'at least one numeric array case' => [
                'data' => [[null, null, 5], null, false, true],
                'expected' => true
            ],
            'at least one numeric array case with 0' => [
                'data' => [[null, null, 0], null, false, true],
                'expected' => true
            ],
            'full material string array case' => [
                'data' => [['lorem', 'ipsum'], Target::$flag_is_material_array_string, false, false],
                'expected' => true
            ],
            'full material string array case with wrong flag' => [
                'data' => [['lorem', 'ipsum'], Target::$flag_is_material_array_collection, false, false],
                'expected' => false
            ],
            'full material list array case' => [
                'data' => [[[1], [2], [5]], Target::$flag_is_material_array_list, false, false],
                'expected' => true
            ],
            'incorrect flag positive case' => [
                'data' => [[2, 3, 5], Target::$flag_is_material_array_collection + 10, false, false],
                'expected' => true
            ],
            'incorrect flag negative case' => [
                'data' => [[2, 3, 5], Target::$flag_is_material_array_string, false, false],
                'expected' => false
            ],
            'numeric strict case' => [
                'data' => [[2, 3, 5], Target::$flag_is_material_array_number, true, false],
                'expected' => true
            ],
            'numeric strict negative case' => [
                'data' => [[0, 1, 1, 2, 3, 5], Target::$flag_is_material_array_number, true, false],
                'expected' => false
            ],
            'at least one list array case with empty item' => [
                'data' => [[null, null, []], Target::$flag_is_material_array_list, true, true],
                'expected' => false
            ],
            'at least one item array case with empty item without flag' => [
                'data' => [[null, null, []], null, true, true],
                'expected' => false
            ]
        ];
    }

    /**
     * Test `arrayMaterialItems` static method
     *
     * @param array $data
     * @param array $expected
     * @return void
     * @group utility
     * @group done
     * @dataProvider arrayMaterialItemsProvider
     */
    public function testArrayMaterialItems(array $data, array $expected): void
    {
        $result = Target::arrayMaterialItems(...$data);

        $this->assertEquals($expected, $result);
    }

    /**
     * Data for testArrayMaterialItems
     *
     * @return array
     */
    public function arrayMaterialItemsProvider(): array
    {
        return [
            'simple $noZero case' => [
                'data' => [[
                    'lorem ipsum',
                    null,
                    0,
                    235,
                    [],
                    new \StdClass()
                ], true],
                'expected' => [
                    'lorem ipsum',
                    235
                ]
            ],
            'simple case with possible zeros' => [
                'data' => [[
                    'lorem ipsum',
                    null,
                    0,
                    235,
                    [],
                    new \StdClass()
                ], false],
                'expected' => [
                    'lorem ipsum',
                    0,
                    235
                ]
            ],
            'associative simple case' => [
                'data' => [[
                    'veni' => 'lorem ipsum',
                    'vidi' => [],
                    'vici' => ['lorem ipsum']
                ], true],
                'expected' => [
                    'veni' => 'lorem ipsum',
                    'vici' => ['lorem ipsum']
                ]
            ],
            'blanked resultcase' => [
                'data' => [[
                    'lorem' => '',
                    'ipsum' => null
                ], true],
                'expected' => []
            ]
        ];
    }
































    /**
     * Test `startInUrl` static method
     *
     * @param array $data
     * @param bool $expected
     * @return void
     * @group utility
     * @group done
     * @dataProvider startInUrlProvider
     */
    public function testStartInUrl(array $data, bool $expected): void
    {
        $result = Target::startInUrl(...$data);

        $this->assertEquals($expected, $result);
    }

    /**
     * Data for testStartInUrl
     *
     * @return array
     */
    public function startInUrlProvider(): array
    {
        return [
            'correct case' => [
                'data' => ['https://spbcrew.com/en/admin/work/list', 'admin'],
                'expected' => true
            ],
            'incorrect case' => [
                'data' => ['https://spbcrew.com/en/admin/work/list', 'work'],
                'expected' => false
            ]
        ];
    }

    /**
     * Test `cutUrlQueryParameters` static method
     *
     * @param string $data
     * @param array $expected
     * @return void
     * @group utility
     * @group done
     * @dataProvider cutUrlQueryParametersProvider
     */
    public function testCutUrlQueryParameters(string $data, array $expected): void
    {
        $result = Target::cutUrlQueryParameters($data);

        $this->assertEquals($expected, $result);
    }

    /**
     * Data for testCutUrlQueryParameters
     *
     * @return array
     */
    public function cutUrlQueryParametersProvider(): array
    {
        return [
            'empty case' => [
                'data' => 'https://spbcrew.com/en/admin/work/list',
                'expected' => []
            ],
            'simple corect case' => [
                'data' => 'https://spbcrew.com/en/admin/work/list?first=lorem&second=ipsum',
                'expected' => [
                    'first' => 'lorem',
                    'second' => 'ipsum'
                ]
            ]
        ];
    }

    /**
     * Test `className` static method
     *
     * @param string $data
     * @param string $expected
     * @return void
     * @group utility
     * @group done
     * @dataProvider classNameProvider
     */
    public function testClassName(string $data, string $expected): void
    {
        $result = Target::className($data);

        $this->assertEquals($expected, $result);
    }

    /**
     * Data for testClassName
     *
     * @return array
     */
    public function classNameProvider(): array
    {
        return [
            'correct case' => [
                'data' => \get_class(new Portal()),
                'expected' => 'Portal'
            ]
        ];
    }

    /**
     * Test `classPath` static method
     *
     * @param array $data
     * @param string $expected
     * @return void
     * @group utility
     * @group done
     * @dataProvider classPathProvider
     */
    public function testClassPath(array $data, string $expected): void
    {
        $result = Target::classPath(...$data);

        $this->assertEquals($expected, $result);
    }

    /**
     * Data for testClassPath
     *
     * @return array
     */
    public function classPathProvider(): array
    {
        return [
            'no save slash case' => [
                'data' => [\get_class(new Portal())],
                'expected' => 'App\Entity\Portal'
            ],
            'save slash case' => [
                'data' => ['Proxies\__CG__\\'.\get_class(new Portal()), true],
                'expected' => '\App\Entity\Portal'
            ]
        ];
    }
}
