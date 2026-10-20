<?php

namespace App\Concerns;

use Closure;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * @method static void saved(\Closure|string|array $callback)
 * @method static void deleted(\Closure|string|array $callback)
 * @method string getTable()
 */

trait HasCachedResource
{
    protected static function bootHasCachedResource(): void
    {
        $invalidate = fn() => DB::afterCommit(fn() => static::invalidateCache());

        static::saved($invalidate);
        static::deleted($invalidate);
    }


    public static function cached(Closure $query, string $suffix, int $ttl = 3600): array
    {
        $version = Cache::rememberForever(static::cacheVersionKey(), fn() => Str::random(16));
        $key = static::cachePrefix() . ":{$version}:{$suffix}";

        return Cache::remember($key, $ttl, fn() => $query()->response()->getData(true));
    }


    protected static function cachePrefix(): string
    {
        return (new static)->getTable();
    }


    protected static function cacheVersionKey(): string
    {
        return static::cachePrefix() . ':version';
    }


    public static function invalidateCache(): void
    {
        Cache::forever(static::cacheVersionKey(), Str::random(16));
    }
}
