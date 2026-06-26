<?php
namespace Mcpuishor\QdrantLaravel\Facades;

use Illuminate\Support\Facades\Facade;
use Mcpuishor\QdrantLaravel\QdrantClient;
use Mcpuishor\QdrantLaravel\Schema\Schema;

/**
 * @method static QdrantClient collection(?string $name = null)
 * @method static Schema schema()
 */
class Qdrant extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'qdrantclient';
    }
}
