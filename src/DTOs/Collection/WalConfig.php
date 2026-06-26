<?php
namespace Mcpuishor\QdrantLaravel\DTOs\Collection;

readonly class WalConfig
{
    public function __construct(
        public int $wal_capacity_mb,
        public int $wal_segments_ahead,
    ) {}

    /**
     * @param  array<string, int>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            wal_capacity_mb: $data['wal_capacity_mb'],
            wal_segments_ahead: $data['wal_segments_ahead'],
        );
    }

    /**
     * @return array<string, int>
     */
    public function toArray(): array
    {
        return [
            'wal_capacity_mb' => $this->wal_capacity_mb,
            'wal_segments_ahead' => $this->wal_segments_ahead,
        ];
    }

}
