<?php declare(strict_types=1);

namespace Becklyn\Hosting\Config;


class HostingConfig
{
    /**
     * @var array
     */
    private $config;


    /**
     * @param array $config
     */
    public function __construct (array $config)
    {
        $this->config = $config;
    }


    /**
     * @return string
     */
    public function getDeploymentTier () : string
    {
        return $this->config["tier"];
    }
}
