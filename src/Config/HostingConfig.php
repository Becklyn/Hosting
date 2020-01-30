<?php declare(strict_types=1);

namespace Becklyn\Hosting\Config;

use Becklyn\Hosting\Project\ProjectVersion;

class HostingConfig
{
    /** @var array */
    private $config;

    /** @var ProjectVersion */
    private $projectVersion;


    /**
     */
    public function __construct (array $config, ProjectVersion $projectVersion)
    {
        $this->config = $config;
        $this->projectVersion = $projectVersion;
    }


    /**
     */
    public function getDeploymentTier () : string
    {
        return $this->config["tier"];
    }


    /**
     */
    public function isInDevelopmentTier () : bool
    {
        return "development" === $this->config["tier"];
    }


    /**
     */
    public function getGitCommit () : ?string
    {
        return $this->projectVersion->getVersion();
    }


    /**
     * Returns the track js tracking code.
     */
    public function getTrackJsToken () : ?string
    {
        return null !== $this->config["trackjs"]
            ? (string) $this->config["trackjs"]
            : null;
    }


    /**
     */
    public function getUptimeMonitorHtmlString () : string
    {
        return \sprintf(
            '<!-- uptime monitor: %s -->',
            \htmlspecialchars($this->getProjectInstallationKey(), \ENT_QUOTES)
        );
    }


    /**
     */
    public function getProjectName () : string
    {
        return $this->config["project_name"];
    }


    /**
     */
    public function getProjectInstallationKey () : string
    {
        return $this->config["installation_key"];
    }
}
