<?php

namespace Hulkur\HasManyKeyBy;

use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    public function register()
    {
        Collection::macro('mapToDictionaryWithKey', function (callable $callback, $keyBy = null) {
            $dictionary = [];

            foreach ($this->items as $key => $item) {
                $pair = $callback($item, $key);

                $key = key($pair);

                $value = reset($pair);

                if (!isset($dictionary[$key])) {
                    $dictionary[$key] = [];
                }

                if (!is_null($keyBy)) {
                    /** @var Collection $this */
                    $innerKey = $this->useAsCallable($keyBy) ? $keyBy($item) : data_get($item, $keyBy);
                    $dictionary[$key][$innerKey] = $value;
                } else {
                    $dictionary[$key][] = $value;
                }
            }

            return new static($dictionary);
        });
    }
}
