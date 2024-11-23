<?php

namespace Hulkur\HasManyKeyBy;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @template TRelatedModel of \Illuminate\Database\Eloquent\Model
 * @template TDeclaringModel of \Illuminate\Database\Eloquent\Model
 *
 * @extends \Illuminate\Database\Eloquent\Relations\HasMany<TRelatedModel, TDeclaringModel>
 */
class HasManyKeyBy extends HasMany
{
    protected $keyBy = null;

    /**
     * Set the key by with results of the relationship are returned.
     *
     * @param string|callable $keyBy
     * @return $this
     */
    public function keyBy($keyBy): self
    {
        $this->keyBy = $keyBy;

        return $this;
    }

    /**
     * Build model dictionary keyed by the relation's foreign key.
     *
     * @param  \Illuminate\Database\Eloquent\Collection<int, TRelatedModel>  $results
     * @return array<array<int, TRelatedModel>>
     */
    protected function buildDictionary(Collection $results)
    {
        $foreign = $this->getForeignKeyName();
        return $results->mapToDictionaryWithKey(function ($result) use ($foreign) {
            return [$result->{$foreign} => $result];
        }, $this->keyBy)->all();
    }
}
