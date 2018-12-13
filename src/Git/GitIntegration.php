<?php declare(strict_types=1);

namespace Becklyn\Hosting\Git;

use Psr\Log\LoggerInterface;
use Psr\SimpleCache\CacheException;
use Psr\SimpleCache\CacheInterface;


class GitIntegration
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


    public function __construct (CacheInterface $cache, ?LoggerInterface $logger)
    {
        $this->cache = $cache;
        $this->logger = $logger;
    }


    /**
     * @return string|null
     */
    public function getVersion () : ?string
    {
        if (!$this->initialized)
        {
            $this->version = $this->fetchVersion();
            $this->initialized = true;
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

        $git = $this->run('command -v git');

        if ("" === $git)
        {
            return null;
        }

        return $this->run("{$git} rev-parse HEAD");
    }


    /**
     * Runs the given command
     *
     * @param string $command
     * @return string|null
     */
    private function run (string $command) : ?string
    {
        $result = \shell_exec($command);

        if (null === $result)
        {
            return null;
        }

        $result = \trim($result);

        return "" !== $result
            ? $result
            : null;
    }
}
