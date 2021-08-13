<?php declare(strict_types=1);

use Becklyn\Hosting\Config\HostingConfig;
use Becklyn\Hosting\Project\ProjectVersion;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class HostingConfigTest extends TestCase
{
    public function testFull () : void
    {
        /** @var MockObject|ProjectVersion $projectVersion */
        $projectVersion = $this->getMockBuilder(ProjectVersion::class)
            ->disableOriginalConstructor()
            ->getMock();

        $projectVersion->method("getVersion")
            ->willReturn("28fdd5c571ee58bba85ed2a0e1498e1d");

        $hostingConfig = new HostingConfig(
            [
                "tier" => "development",
                "trackjs" => "thisIsAToken",
                "project_name" => "test",
            ],
            $projectVersion
        );

        self::assertSame("development", $hostingConfig->getDeploymentTier());
        self::assertSame("thisIsAToken", $hostingConfig->getTrackJsToken());
        self::assertSame("<!-- uptime monitor: test -->", $hostingConfig->getUptimeMonitorHtmlString());
        self::assertSame("test", $hostingConfig->getProjectName());
        self::assertSame("28fdd5c571ee58bba85ed2a0e1498e1d", $hostingConfig->getGitCommit());
        self::assertTrue($hostingConfig->isInDevelopmentTier());

        $hostingConfigFailures = new HostingConfig(
            [
                "tier" => "production",
                "trackjs" => null,
                "project_name" => "test",
            ],
            $projectVersion
        );

        self::assertSame("production", $hostingConfigFailures->getDeploymentTier());
        self::assertNull($hostingConfigFailures->getTrackJsToken());
        self::assertFalse($hostingConfigFailures->isInDevelopmentTier());
    }
}
