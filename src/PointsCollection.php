<?php
namespace Mcpuishor\QdrantLaravel;

use Illuminate\Support\Collection;
use Mcpuishor\QdrantLaravel\DTOs\Point;

/**
 * @extends Collection<int|string, mixed>
 * @phpstan-consistent-constructor
 */
class PointsCollection extends Collection
{
    /**
     * @return array<int|string, mixed>
     */
    public function toArray():array
    {
        return $this->map(function ($item) {
            if ($item instanceof Point) {
                return $item->toArray();
            }

            if ($item instanceof Collection) {
                return (new self($item))->toArray();
            }

            if (is_array($item)) {
                return array_map(function ($value) {
                    if ($value instanceof Point) {
                        return $value->toArray();
                    }
                    if ($value instanceof Collection) {
                        return (new self($value))->toArray();
                    }
                    return $value;
                }, $item);
            }

            return $item;
        })->all();
    }

    /**
     * @param  mixed  $items
     * @param  mixed  ...$args
     */
    public static function make($items = [], ...$args): self
    {
        return new static($items);
    }

}
