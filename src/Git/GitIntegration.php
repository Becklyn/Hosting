<?php declare(strict_types=1);

namespace Becklyn\Hosting\Git;

use Psr\Log\LoggerInterface;
use Psr\SimpleCache\CacheException;
use Symfony\Component\Cache\Simple\Psr6Cache;


class GitIntegration
{
    const CACHE_KEY = "becklyn.hosting.version";

    /**
     * @var Psr6Cache
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


    public function __construct (Psr6Cache $cache, ?LoggerInterface $logger)
    {
        $this->cache = $cache;
        $this->logger = $logger;
    }


    /**
     * @return string|null
     */
    public function getVersion () : ?string
    {
        if ($this->initialized)
        {
            $this->version = $this->fetchVersion();
        }

        return $this->version;
    }


    /**
     * Fetches the current version
     *
     * @return string|null
     */
    private function fetchVersion () : ?string
    {
        try
        {
            $version = $this->cache->get(self::CACHE_KEY);

            if (null !== $version)
            {
                return $version;
            }
        }
        catch (CacheException $e)
        {
            if (null !== $this->logger)
            {
                $this->logger->error("Reading the cache failed, due to {message}", [
                    "message" => $e->getMessage(),
                    "exception" => $e,
                ]);
            }
        }

        $git = \trim(\shell_exec('which git'));

        if ("" === $git)
        {
            return null;
        }

        $parsed = \trim(\shell_exec("{$git} rev-parse HEAD"));

        return "" !== $parsed
            ? $parsed
            : null;
    }
}
