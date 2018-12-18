<?php declare(strict_types=1);

namespace Becklyn\Hosting\Project;

use Becklyn\Hosting\Git\GitIntegration;
use Psr\Cache\CacheItemPoolInterface;
use Psr\SimpleCache\CacheInterface;


/**
 * Fetches the version of the project
 */
class ProjectVersion
{

    const CACHE_KEY = "becklyn.hosting.version";

    /**
     * @var CacheInterface
     */
    private $cache;


    /**
     * @var string|null
     */
    private $version;


    /**
     * @var bool
     */
    private $initialized = false;


    /**
     * @var GitIntegration
     */
    private $gitIntegration;


    /**
     * @var CacheItemPoolInterface
     */
    private $cachePool;


    public function __construct (GitIntegration $gitIntegration, CacheItemPoolInterface $cachePool)
    {
        $this->cachePool = $cachePool;
        $this->cacheItem = $cachePool->getItem(self::CACHE_KEY);
        $this->gitIntegration = $gitIntegration;

        // fetch data from cache
        $version = $this->cache->get(self::CACHE_KEY);
        if ($this->cacheItem->isHit() && null !== $this->cacheItem->get())
        {
            $this->version = $this->cacheItem->get();
            $this->initialized = true;
        }
    }

    /**
     * @return string|null
     */
    public function getVersion () : ?string
    {
        if (!$this->initialized)
        {
            $this->version = $this->gitIntegration->fetchHeadCommitHash();
            $this->initialized = true;

            $this->cacheItem->set($this->version);
            $this->cachePool->save($this->cacheItem);
        }

        return $this->version;
    }
}
