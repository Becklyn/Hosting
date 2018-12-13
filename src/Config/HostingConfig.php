<?php declare(strict_types=1);

namespace Becklyn\Hosting\Config;


use Becklyn\Hosting\Git\GitIntegration;
use Becklyn\Hosting\Project\ProjectVersion;


class HostingConfig
{
    /**
     * @var array
     */
    private $config;


    /**
     * @var ProjectVersion
     */
    private $projectVersion;


    /**
     * @param array          $config
     * @param GitIntegration $gitIntegration
     */
    public function __construct (array $config, ProjectVersion $projectVersion)
    {
        $this->config = $config;
        $this->projectVersion = $projectVersion;
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
        return $this->projectVersion->getVersion();
    }
}
