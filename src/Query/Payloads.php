<?php
namespace Mcpuishor\QdrantLaravel\Query;

use InvalidArgumentException;
use Mcpuishor\QdrantLaravel\PointsCollection;
use Mcpuishor\QdrantLaravel\QdrantTransport;
use Mcpuishor\QdrantLaravel\Traits\HasFilters;

class Payloads
{
    use HasFilters;

    /** @var array<int, int|string> */
    private array $points = [];

    public function __construct(
        private QdrantTransport $transport,
        private ?string $collection,
    ){
        $this->transport = $this->transport->baseUri("/collections/{$this->collection}/points/payload");
    }

    /**
     * @param  array<int, int|string>|PointsCollection  $points
     */
    public function for( array|PointsCollection $points ) :self
    {
        if (is_array($points)) {
            $this->points  = $points;
        } else {
            $this->points = $points->pluck('id')->toArray();
        }

        return $this;
    }
    /**
     * @param  array<string, mixed>  $payload
     */
    public function set(array $payload): bool
    {
        return $this->sendRequest('POST', $payload);
    }

    /**
     * @param  array<string, mixed>  $payload
     */
    public function overwrite(array $payload): bool
    {
        return $this->sendRequest('PUT', $payload);
    }

    /**
     * @param  array<int, string>  $keys
     */
    public function clear(array $keys): bool
    {
        return $this->transport->post(
            uri: '/delete',
            options: [
                'points' => $this->points,
                'keys' => $keys,
            ]
        )->isOk();
    }

    public function purge(): bool
    {
        return $this->transport->post(
            uri: '/clear',
            options: [
                'points' => $this->points,
            ]
        )->isOk();
    }

    /**
     * @param  array<string, mixed>  $payload
     */
    private function sendRequest(string $method, array $payload): bool
    {
        $requestOptions = [
            'points' => $this->points,
            'payload' => $payload,
        ];

        $result =  match($method) {
            'POST' => $this->transport
                        ->post(
                            uri:'',
                            options: $requestOptions,
                        ),
            'PUT' => $this->transport
                        ->put(
                            uri: '',
                            options: $requestOptions,
                     ),
            default => throw new InvalidArgumentException("Unsupported payload request method [$method]."),
        };

        return $result->isOk();
    }
}
