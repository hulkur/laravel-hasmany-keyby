<?php

namespace Hulkur\HasManyKeyBy\Test;

use Illuminate\Support\Collection;

class CollectionTest extends TestCase
{
    public function testMapToDictionaryWithKeyByAsString()
    {
        $data = new Collection([
            ['id' => 1, 'name' => 'A', 'key' => 4],
            ['id' => 2, 'name' => 'B', 'key' => 3],
            ['id' => 3, 'name' => 'C', 'key' => 2],
            ['id' => 4, 'name' => 'B', 'key' => 1],
        ]);

        $groups = $data->mapToDictionaryWithKey(
            function ($item, $key) {
                return [$item['name'] => $item['id']];
            },
            'key'
        );

        $this->assertInstanceOf(Collection::class, $groups);
        $this->assertEquals(['A' => [4 => 1], 'B' => [3 => 2, 1 => 4], 'C' => [2 => 3]], $groups->toArray());
        $this->assertIsArray($groups['A']);
    }

    public function testMapToDictionaryWithKeyByAsCallable()
    {
        $data = new Collection([
            ['id' => 1, 'name' => 'A'],
            ['id' => 2, 'name' => 'B'],
            ['id' => 3, 'name' => 'C'],
            ['id' => 4, 'name' => 'B'],
        ]);

        $groups = $data->mapToDictionaryWithKey(
            function ($item, $key) {
                return [$item['name'] => $item['id']];
            },
            function ($item) {
                return 2 * $item['id'];
            }
        );

        $this->assertInstanceOf(Collection::class, $groups);
        $this->assertEquals(['A' => [2 => 1], 'B' => [4 => 2, 8 => 4], 'C' => [6 => 3]], $groups->toArray());
        $this->assertIsArray($groups['A']);
    }
}
