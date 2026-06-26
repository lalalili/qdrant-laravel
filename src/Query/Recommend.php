<?php
namespace Mcpuishor\QdrantLaravel\Query;

use Mcpuishor\QdrantLaravel\Enums\AverageVectorStrategy;
use Mcpuishor\QdrantLaravel\Exceptions\SearchException;
use Mcpuishor\QdrantLaravel\PointsCollection;
use Mcpuishor\QdrantLaravel\Traits\HasFilters;

class Recommend extends Search
{
    use HasFilters;

    /** @var array<int, int|string> */
    private array $positives = [];
    /** @var array<int, int|string> */
    private array $negatives = [];
    private ?AverageVectorStrategy $strategy = null;

    /**
     * @param  array<int, int|string>|int|string  $ids
     */
    public function positive(array|string|int $ids): self
    {
        $this->positives = array_merge($this->positives, (array)$ids);
        return $this;
    }

    /**
     * @param  array<int, int|string>|int|string  $ids
     */
    public function negative(array|string|int $ids): self
    {
        $this->negatives = array_merge($this->negatives, (array)$ids);
        return $this;
    }

    public function strategy(AverageVectorStrategy $strategy): self
    {
        $this->strategy = $strategy;
        return $this;
    }

    public function get(): PointsCollection
    {
        $query = is_array($this->query) ? $this->query : [];

        if ($this->positives) {
            $query['positive'] = $this->positives;
        }

        if ($this->negatives) {
            $query['negative'] = $this->negatives;
        }

        $query['strategy'] = $this->strategy->value ?? AverageVectorStrategy::default()->value;

        $this->query = [
            'recommend' => $query,
        ];

        return parent::get();
    }
}
