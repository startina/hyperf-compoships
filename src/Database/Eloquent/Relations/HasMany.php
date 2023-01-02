<?php

namespace Startina\Database\Eloquent\Relations;

use Hyperf\Database\Model\Collection;
use Hyperf\Database\Model\Relations\HasMany as BaseHasMany;

/**
 * @template TRelatedModel of \Illuminate\Database\Eloquent\Model
 * @extends BaseHasMany<TRelatedModel>
 */
class HasMany extends BaseHasMany
{
    use HasOneOrMany;

    /**
     * Get the results of the relationship.
     *
     * @return mixed
     */
    public function getResults()
    {
        if (!is_array($this->getParentKey())) {
            return !is_null($this->getParentKey()) ? $this->query->get() : $this->related->newCollection();
        }

        return $this->query->get();
    }

    /**
     * Initialize the relation on a set of models.
     *
     * @param array  $models
     * @param string $relation
     *
     * @return array
     */
    public function initRelation(array $models, $relation)
    {
        foreach ($models as $model) {
            $model->setRelation($relation, $this->related->newCollection());
        }

        return $models;
    }

    /**
     * Match the eagerly loaded results to their parents.
     *
     * @return array
     */
    public function match(array $models, Collection $results, $relation)
    {
        return $this->matchMany($models, $results, $relation);
    }
}
