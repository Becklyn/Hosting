<?php declare(strict_types=1);

namespace Becklyn\Hosting\Project;

use Becklyn\Hosting\Git\GitIntegration;
use Psr\Log\LoggerInterface;
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
     * @var LoggerInterface|null
     */
    private $logger;


    /**
     * @var GitIntegration
     */
    private $gitIntegration;


    public function __construct (GitIntegration $gitIntegration, CacheInterface $cache, ?LoggerInterface $logger)
    {
        $this->cache = $cache;
        $this->logger = $logger;
        $this->gitIntegration = $gitIntegration;
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
        }

        return $this->version;
    }
}
