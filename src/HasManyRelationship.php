<?php

namespace Hulkur\HasManyKeyBy;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * This trait will replace all HasMany relations in a class with HasManyKeyBy relation
 * as it overwrites newHasMany method from HasRelations trait that instantiates the
 * actual relation class.
 */

trait HasManyKeyByRelationship
{
    /**
     * Instantiate a new HasManyKeyBy relationship.
     *
     * @param Builder $query
     * @param Model $parent
     * @param string $foreignKey
     * @param string $localKey
     * @return HasManyKeyBy
     */
    protected function newHasMany(Builder $query, Model $parent, $foreignKey, $localKey)
    {
        return new HasManyKeyBy($query, $parent, $foreignKey, $localKey);
    }
}