<?php

namespace Hulkur\HasManyKeyBy\Test;

use Hulkur\HasManyKeyBy\HasManyKeyBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Mockery as m;

class DatabaseTest extends TestCase
{
    public function testModelsAreProperlyMatchedToParentsWithKeyByAsString()
    {
        $relation = $this->getRelation()
            ->keyBy('keyByField');

        $result1 = new EloquentHasManyModelStub;
        $result1->foreign_key = 1;
        $result1->keyByField = 3;
        $result2 = new EloquentHasManyModelStub;
        $result2->foreign_key = 2;
        $result2->keyByField = 4;
        $result3 = new EloquentHasManyModelStub;
        $result3->foreign_key = 2;
        $result3->keyByField = 5;

        $model1 = new EloquentHasManyModelStub;
        $model1->id = 1;
        $model2 = new EloquentHasManyModelStub;
        $model2->id = 2;
        $model3 = new EloquentHasManyModelStub;
        $model3->id = 3;

        $relation->getRelated()->shouldReceive('newCollection')->andReturnUsing(function ($array) {
            return new Collection($array);
        });
        $models = $relation->match([$model1, $model2, $model3], new Collection([$result1, $result2, $result3]), 'foo');

        $this->assertEquals(1, $models[0]->foo[3]->foreign_key);
        $this->assertEquals(3, $models[0]->foo[3]->keyByField);
        $this->assertCount(1, $models[0]->foo);
        $this->assertEquals(2, $models[1]->foo[4]->foreign_key);
        $this->assertEquals(4, $models[1]->foo[4]->keyByField);
        $this->assertEquals(2, $models[1]->foo[5]->foreign_key);
        $this->assertEquals(5, $models[1]->foo[5]->keyByField);
        $this->assertCount(2, $models[1]->foo);
        $this->assertNull($models[2]->foo);
    }

    public function testModelsAreProperlyMatchedToParentsWithKeyByAsCallable()
    {
        $relation = $this->getRelation()
            ->keyBy(function ($item) {
                return 2 * $item->keyByField;
            });

        $result1 = new EloquentHasManyModelStub;
        $result1->foreign_key = 1;
        $result1->keyByField = 3;
        $result2 = new EloquentHasManyModelStub;
        $result2->foreign_key = 2;
        $result2->keyByField = 4;
        $result3 = new EloquentHasManyModelStub;
        $result3->foreign_key = 2;
        $result3->keyByField = 5;

        $model1 = new EloquentHasManyModelStub;
        $model1->id = 1;
        $model2 = new EloquentHasManyModelStub;
        $model2->id = 2;
        $model3 = new EloquentHasManyModelStub;
        $model3->id = 3;

        $relation->getRelated()->shouldReceive('newCollection')->andReturnUsing(function ($array) {
            return new Collection($array);
        });
        $models = $relation->match([$model1, $model2, $model3], new Collection([$result1, $result2, $result3]), 'foo');

        $this->assertEquals(1, $models[0]->foo[6]->foreign_key);
        $this->assertEquals(3, $models[0]->foo[6]->keyByField);
        $this->assertCount(1, $models[0]->foo);
        $this->assertEquals(2, $models[1]->foo[8]->foreign_key);
        $this->assertEquals(4, $models[1]->foo[8]->keyByField);
        $this->assertEquals(2, $models[1]->foo[10]->foreign_key);
        $this->assertEquals(5, $models[1]->foo[10]->keyByField);
        $this->assertCount(2, $models[1]->foo);
        $this->assertNull($models[2]->foo);
    }

    protected function getRelation()
    {
        $builder = m::mock(Builder::class);
        $builder->shouldReceive('whereNotNull')->with('table.foreign_key');
        $builder->shouldReceive('where')->with('table.foreign_key', '=', 1);
        $related = m::mock(Model::class);
        $builder->shouldReceive('getModel')->andReturn($related);
        $parent = m::mock(Model::class);
        $parent->shouldReceive('getAttribute')->with('id')->andReturn(1);
        $parent->shouldReceive('getCreatedAtColumn')->andReturn('created_at');
        $parent->shouldReceive('getUpdatedAtColumn')->andReturn('updated_at');

        return new HasManyKeyBy($builder, $parent, 'table.foreign_key', 'id');
    }
}

class EloquentHasManyModelStub extends Model
{
    public $foreign_key = 'foreign.value';
}
