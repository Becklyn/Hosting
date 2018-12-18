<?php declare(strict_types=1);

namespace Becklyn\Hosting\Project;

use Becklyn\Hosting\Git\GitIntegration;
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


    public function __construct (GitIntegration $gitIntegration, CacheInterface $cache)
    {
        $this->cache = $cache;
        $this->gitIntegration = $gitIntegration;

        // fetch data from cache
        $version = $this->cache->get(self::CACHE_KEY);
        if (null !== $version)
        {
            $this->version = $version;
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
            $this->cache->set(self::CACHE_KEY, $this->version);
        }

        return $this->version;
    }
}
