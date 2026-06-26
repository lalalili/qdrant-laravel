<?php
namespace Mcpuishor\QdrantLaravel\DTOs;

use Mcpuishor\QdrantLaravel\DTOs\Quantization\QuantizationObject;
use Mcpuishor\QdrantLaravel\Enums\DistanceMetric;
use Mcpuishor\QdrantLaravel\Enums\VectorDatatype;

readonly class Vector
{
    public function __construct(
        public int $size,
        public DistanceMetric $distance,
        public ?HnswConfig $hnsw_config = null,
        public ?QuantizationObject $quantization_config = null,
        public bool $on_disk = false,
        public ?VectorDatatype $datatype = null,
    ){}

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        $values = collect([
            'size' => $this->size,
            'distance' => $this->distance->value,
            'hnsw_config' => $this->hnsw_config?->toArray() ?? null,
            'quantization' => $this->quantization_config?->toArray() ?? null,
            'on_disk' => $this->on_disk ? true : null,
            'datatype' => $this->datatype->value ?? null,
        ]);

        return $values->filter()->toArray();
    }
    /**
     * @param  array<string, mixed>  $options
     */
    static function fromArray(array $options): self
    {
        return new self(...$options);
    }
}
