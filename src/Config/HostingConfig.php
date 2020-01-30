<?php declare(strict_types=1);

namespace Becklyn\Hosting\Config;

use Becklyn\Hosting\Exception\InvalidTierException;
use Becklyn\Hosting\Project\ProjectVersion;

class HostingConfig
{
    public const ALLOWED_TIERS = [
        "development",
        "staging",
        "production",
    ];

    /** @var array */
    private $config;

    /** @var ProjectVersion */
    private $projectVersion;

    /** @var string */
    private $tier;


    /**
     */
    public function __construct (array $config, ProjectVersion $projectVersion)
    {
        $tier = $config["tier"];

        // It's important to make this check as early as possible. This service is always constructed,
        // so the exception should be thrown immediately. Otherwise one might miss it if it is checked lazily.
        if (!\in_array($config["tier"], self::ALLOWED_TIERS, true))
        {
            throw new InvalidTierException(\sprintf(
                "Invalid hosting tier '%s' configured. Only allowed values are: %s",
                $tier,
                \implode(", ", self::ALLOWED_TIERS)
            ));
        }

        $this->tier = $tier;
        $this->config = $config;
        $this->projectVersion = $projectVersion;
    }


    /**
     */
    public function getDeploymentTier () : string
    {
        return $this->tier;
    }


    /**
     */
    public function isInDevelopmentTier () : bool
    {
        return "development" === $this->tier;
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
        return !empty($this->config["trackjs"])
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
        return $this->config["project"];
    }


    /**
     */
    public function getProjectInstallationKey () : string
    {
        return $this->config["installation"];
    }
}
