<?php declare(strict_types=1);

namespace Becklyn\Hosting;

use Becklyn\Hosting\DependencyInjection\BecklynHostingExtension;
use Symfony\Component\HttpKernel\Bundle\Bundle;


class BecklynHostingBundle extends Bundle
{
    /**
     * @inheritDoc
     */
    public function getContainerExtension ()
    {
        return new BecklynHostingExtension();
    }
}
