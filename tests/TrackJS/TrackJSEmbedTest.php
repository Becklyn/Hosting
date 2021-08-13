<?php declare(strict_types=1);

namespace Tests\Becklyn\Hosting\TrackJS;

use Becklyn\AssetsBundle\Helper\AssetHelper;
use Becklyn\Hosting\Config\HostingConfig;
use Becklyn\Hosting\TrackJS\TrackJSEmbed;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class TrackJSEmbedTest extends TestCase
{
    public function testGetEmbedHtmlInDebugMode () : void
    {
        /** @var MockObject|AssetHelper $assetHelper */
        $assetHelper = $this->getMockBuilder(AssetHelper::class)
            ->disableOriginalConstructor()
            ->getMock();

        // region not in debug
        /** @var MockObject|HostingConfig $hostingConfigEmptyToken */
        $hostingConfigEmptyToken = $this->getMockBuilder(HostingConfig::class)
            ->disableOriginalConstructor()
            ->getMock();

        $hostingConfigEmptyToken->expects($this->atLeastOnce())
            ->method("getTrackJsToken")
            ->willReturn("thisIsAToken");

        $hostingConfigEmptyToken
            ->method("isInDevelopmentTier")
            ->willReturn(false);

        $trackJsEmbedEmptyToken = new TrackJSEmbed(
            $hostingConfigEmptyToken,
            $assetHelper,
            false
        );

        $this->assertNotEmpty($trackJsEmbedEmptyToken->getEmbedHtml());
        // endregion


        // region empty token
        /** @var MockObject|HostingConfig $hostingConfigEmptyToken */
        $hostingConfigEmptyToken = $this->getMockBuilder(HostingConfig::class)
            ->disableOriginalConstructor()
            ->getMock();

        $hostingConfigEmptyToken->expects($this->atLeastOnce())
            ->method("getTrackJsToken")
            ->willReturn(null);

        $hostingConfigEmptyToken->method("isInDevelopmentTier")
            ->willReturn(false);

        $trackJsEmbedEmptyToken = new TrackJSEmbed(
            $hostingConfigEmptyToken,
            $assetHelper,
            false
        );

        $this->assertEmpty($trackJsEmbedEmptyToken->getEmbedHtml());
        // endregion

        // region isDebug
        /** @var MockObject|HostingConfig $hostingConfigIsDebug */
        $hostingConfigIsDebug = $this->getMockBuilder(HostingConfig::class)
            ->disableOriginalConstructor()
            ->getMock();

        $hostingConfigIsDebug->expects($this->atLeastOnce())
            ->method("getTrackJsToken")
            ->willReturn("thisIsAToken");

        $hostingConfigIsDebug->method("isInDevelopmentTier")
            ->willReturn(true);

        $trackJsEmbedIsDebug = new TrackJSEmbed(
            $hostingConfigIsDebug,
            $assetHelper,
            true
        );

        $this->assertEmpty($trackJsEmbedIsDebug->getEmbedHtml());
        // endregion

        // region tier is not in deployment tiers
        /** @var MockObject|HostingConfig $hostingConfigIsDebug */
        $hostingConfigIsDebug = $this->getMockBuilder(HostingConfig::class)
            ->disableOriginalConstructor()
            ->getMock();

        $hostingConfigIsDebug->expects($this->atLeastOnce())
            ->method("getTrackJsToken")
            ->willReturn("thisIsAToken");

        $hostingConfigIsDebug->expects($this->atLeastOnce())
            ->method("isInDevelopmentTier")
            ->willReturn(true);

        $trackJsEmbedIsDebug = new TrackJSEmbed(
            $hostingConfigIsDebug,
            $assetHelper,
            false
        );

        $this->assertEmpty($trackJsEmbedIsDebug->getEmbedHtml());
        // endregion
    }
}
