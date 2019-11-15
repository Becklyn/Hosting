<?php declare(strict_types=1);

namespace Becklyn\Hosting\Sentry;

class CustomSanitizeDataProcessor extends \Raven_Processor
{
    /**
     * @inheritDoc
     */
    public function process (&$data) : void
    {
        // remove the IP address from the data
        unset($data["user"]["ip_address"]);
    }
}
