<?php declare(strict_types=1);

namespace Becklyn\Hosting\Project;

use Becklyn\Hosting\Git\GitIntegration;
use Symfony\Contracts\Cache\CacheInterface;

/**
 * Fetches the version of the project.
 */
class ProjectVersion
{
    public const CACHE_KEY = "becklyn.hosting.version";

    /** @var string|null */
    private $version;

    /** @var bool */
    private $initialized = false;

    /** @var GitIntegration */
    private $gitIntegration;

    /** @var CacheInterface */
    private $cache;


    /**
     */
    public function __construct (GitIntegration $gitIntegration, CacheInterface $cache)
    {
        $this->gitIntegration = $gitIntegration;
        $this->cache = $cache;
    }


    /**
     */
    public function getVersion () : ?string
    {
        if (!$this->initialized)
        {
            $this->version = $this->cache->get(
                self::CACHE_KEY,
                [$this->gitIntegration, "fetchHeadCommitHash"]
            );

            $this->initialized = true;
        }

        return $this->version;
    }
}
