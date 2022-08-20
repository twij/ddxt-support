<?php

namespace Ddxt\Support\RepositoryCache;

use Closure;

trait RepositoryCache
{
    /**
     * Define unique cache key prefix
     *
     * @return string Cache key prefix
     */
    abstract protected function getCacheKeyPrefix(): string;

    /**
     * Wrapper for remember forever
     *
     * @param  string   $key      Cache key
     * @param  Closure  $closure  Function to remember
     *
     * @return mixed    Closure return data
     */
    public function rememberForever(string $key, Closure $closure): mixed
    {
        return $this->cache->rememberForever(
            $this->getCacheKeyPrefix() . $key,
            $closure
        );
    }

    /**
     * Refresh cached data for a key
     *
     * @param   string   $key      Unique key for data
     * @param   Closure  $closure  Closure for value data
     *
     * @return  mixed    Returned value from closure
     */
    public function refreshForKey(string $key, Closure $closure): mixed
    {
        $this->cache->put($this->getCacheKeyPrefix() . $key, $value = $closure());
        return $value;
    }

    /**
     * Get cahced data by key
     *
     * @param  string  $key  Cache key
     *
     * @return mixed   Cached data
     */
    public function getCachedByKey(string $key): mixed
    {
        return $this->cache->get($this->getCacheKeyPrefix() . $key);
    }

    /**
     * Forget cached key
     *
     * @param  string   $key  Cache key to delete
     *
     * @return void
     */
    public function deleteFromCache(string $key): void
    {
        $this->cache->forget($this->getCacheKeyPrefix() . $key);
    }

    /**
     * Check if cache has key
     *
     * @param  string   $key  Cache key
     *
     * @return boolean  Status
     */
    public function cacheHas(string $key): bool
    {
        return $this->cache->has($this->getCacheKeyPrefix() . $key);
    }
}
