<?php declare(strict_types=1);

namespace Tests\Becklyn\Hosting\Git;

use Becklyn\Hosting\Git\GitIntegration;
use PHPUnit\Framework\TestCase;

class GitIntegrationTest extends TestCase
{
    public function testFetchHeadCommitHash () : void
    {
        $gitIntegration = new GitIntegration(\implode("/", \array_slice(\explode("/", __DIR__), 0, -2)));

        $this->assertNotNull($gitIntegration->fetchHeadCommitHash());
    }
}
