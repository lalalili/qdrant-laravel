<?php
namespace Mcpuishor\QdrantLaravel\DTOs\Collection;

interface ConfigObject
{
    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self;

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array;
}
