<?php

namespace Hulkur\HasManyKeyBy;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
     * @param Collection $results
     * @return array
     */
    protected function buildDictionary(Collection $results)
    {
        $foreign = $this->getForeignKeyName();
        return $results->mapToDictionaryWithKey(function ($result) use ($foreign) {
            return [$result->{$foreign} => $result];
        }, $this->keyBy)->all();
    }
}
