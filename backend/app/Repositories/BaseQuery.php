<?php

namespace App\Repositories;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * @phpstan-template T of Model
 */
abstract class BaseQuery {

    protected Builder $query;

    public function __construct() {
        $this->query = $this->getModelQuery();
    }

    abstract protected function getModelQuery(): Builder;

    public static function create(): static {
        return new static();
    }

    public function get(): Collection {
        return $this->query->get();
    }

    /**
     * @return T|null
     */
    public function first(): Model|null {
        return $this->query->first();
    }

    /**
     * @return T|null
     */
    public function find(int $modelId): Model|null {
        return $this->query->find($modelId);
    }

    public function loadRelation(string $relation): static {
        $this->query->with($relation);
        return $this;
    }
}
