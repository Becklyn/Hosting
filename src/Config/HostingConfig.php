<?php declare(strict_types=1);

namespace Becklyn\Hosting\Config;


use Becklyn\Hosting\Git\GitIntegration;


class HostingConfig
{
    /**
     * @var array
     */
    private $config;


    /**
     * @var GitIntegration
     */
    private $gitIntegration;


    /**
     * @param array          $config
     * @param GitIntegration $gitIntegration
     */
    public function __construct (array $config, GitIntegration $gitIntegration)
    {
        $this->config = $config;
        $this->gitIntegration = $gitIntegration;
    }


    /**
     * @return string
     */
    public function getDeploymentTier () : string
    {
        return $this->config["tier"];
    }


    /**
     * @return string|null
     */
    public function getGitCommit () : ?string
    {
        return $this->gitIntegration->getVersion();
    }
}
