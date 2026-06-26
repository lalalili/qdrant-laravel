<?php
namespace Mcpuishor\QdrantLaravel\DTOs;

readonly class Point
{
    public function __construct(
        public int|string $id,
        /** @var array<int, float|int>|null */
        public ?array      $vector = null,
        /** @var array<string, mixed>|null */
        public ?array      $payload = null,
    ){}

    /**
     * @return array{id: int|string, vector: array<int, float|int>|null, payload: array<string, mixed>|null}
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'vector' => $this->vector,
            'payload' => $this->payload,
        ];
    }

    public function id(): string|int
    {
        return $this->id;
    }

    /**
     * @return array<int, float|int>|null
     */
    public function vector(): ?array
    {
        return $this->vector;
    }

    public function isEmpty(): bool
    {
        return empty($this->vector) && empty($this->payload);
    }
}
