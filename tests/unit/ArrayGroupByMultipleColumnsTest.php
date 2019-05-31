<?php

namespace tests\unit;

use PHPUnit\Framework\TestCase;

class ArrayGroupByMultipleColumnsTest extends TestCase
{
    public function anEmptyArrayReturnsEmpty(): array
    {
        return [
            'An empty array returns empty' => [[], []]
        ];
    }

    public function singleItemArrayIsUnchanged(): array
    {
        return [
            'Single-item array is unchanged' => [
                [
                    ['id' => 1, 's_id' => 1, 'name' => 'foo']
                ],
                [
                    ['id' => 1, 's_id' => 1, 'name' => 'foo']
                ]
            ]
        ];
    }

    public function columnsAreCheckedStrictly(): array
    {
        return [
            'Columns are checked strictly' => [
                [
                    0 => ['id' => 1, 'name' => 'foo'],
                    1 => ['id' => '1', 'name' => 'bar']
                ],
                [
                    ['id' => 1, 'name' => 'foo'],
                    ['id' => '1', 'name' => 'bar']
                ]
            ]
        ];
    }

    public function orderedGroupOfRowsAtTheBeginning(): array
    {
        return [
            'Ordered set at the beginning' => [
                [
                    ['id' => 1, 's_id' => 1, 'name' => 'foo'],
                    ['id' => 1, 's_id' => 1, 'name' => 'bar'],
                    ['id' => 2, 's_id' => 2, 'name' => 'baz'],
                    ['id' => 3, 's_id' => 2, 'name' => 'foobar'],
                    ['id' => 4, 's_id' => 3, 'name' => 'barbaz']
                ],
                [
                    ['id' => 1, 's_id' => 1, 'name' => 'foo'],
                    ['id' => 2, 's_id' => 2, 'name' => 'baz'],
                    ['id' => 3, 's_id' => 2, 'name' => 'foobar'],
                    ['id' => 4, 's_id' => 3, 'name' => 'barbaz']
                ]
            ]
        ];
    }

    public function uniqueGroups(): array
    {
        return [
            'Unique groups #1' => [
                [
                    ['id' => 1, 's_id' => 1, 'name' => 'foo'],
                    ['id' => 2, 's_id' => 1, 'name' => 'bar']
                ],
                [
                    ['id' => 1, 's_id' => 1, 'name' => 'foo'],
                    ['id' => 2, 's_id' => 1, 'name' => 'bar']
                ]
            ],
            'Unique groups #2' => [
                [
                    ['id' => 1, 's_id' => 1, 'name' => 'foo'],
                    ['id' => 2, 's_id' => 1, 'name' => 'bar'],
                    ['id' => 3, 's_id' => 2, 'name' => 'baz'],
                    ['id' => 4, 's_id' => 3, 'name' => 'foobar'],
                    ['id' => 5, 's_id' => 3, 'name' => 'barbaz']
                ],
                [
                    ['id' => 1, 's_id' => 1, 'name' => 'foo'],
                    ['id' => 2, 's_id' => 1, 'name' => 'bar'],
                    ['id' => 3, 's_id' => 2, 'name' => 'baz'],
                    ['id' => 4, 's_id' => 3, 'name' => 'foobar'],
                    ['id' => 5, 's_id' => 3, 'name' => 'barbaz']
                ]
            ]
        ];
    }

    /**
     * @test
     * @dataProvider anEmptyArrayReturnsEmpty
     * @dataProvider singleItemArrayIsUnchanged
     * @dataProvider columnsAreCheckedStrictly
     * @dataProvider orderedGroupOfRowsAtTheBeginning
     * @dataProvider uniqueGroups
     * @param array $testData
     * @param array $expectedOutput
     */
    public function testArrayGroupByMultiple(array $testData, array $expectedOutput)
    {
        $this->assertEquals($expectedOutput, array_group_by(array('id', 's_id'), $testData));
    }
}
