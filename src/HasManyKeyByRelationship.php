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
     * Instantiate a new HasMany relationship.
     *
     * @template TRelatedModel of \Illuminate\Database\Eloquent\Model
     * @template TDeclaringModel of \Illuminate\Database\Eloquent\Model
     *
     * @param  \Illuminate\Database\Eloquent\Builder<TRelatedModel>  $query
     * @param  TDeclaringModel  $parent
     * @param  string  $foreignKey
     * @param  string  $localKey
     * @return HasManyKeyby<TRelatedModel, TDeclaringModel>
     */
    protected function newHasMany(Builder $query, Model $parent, $foreignKey, $localKey)
    {
        return new HasManyKeyBy($query, $parent, $foreignKey, $localKey);
    }
}
