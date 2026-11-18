<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace PyzTest\Zed\Security\Communication;

use Codeception\Test\Unit;
use Pyz\Zed\SecurityGui\SecurityGuiConfig;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestMatcher\PathRequestMatcher;

/**
 * The Back Office and Merchant Portal login pages load their CAPTCHA challenge before anyone is logged in. The Back Office
 * firewall covers every path of both applications, so the access rule of the ignorable paths is what opens each challenge
 * endpoint, and it must open the endpoint only.
 *
 * Auto-generated group annotations
 *
 * @group PyzTest
 * @group Zed
 * @group Security
 * @group Communication
 * @group CaptchaChallengeEndpointAccessTest
 * Add your own group annotations below this line
 */
class CaptchaChallengeEndpointAccessTest extends Unit
{
    protected const string BACKOFFICE_CHALLENGE_PATH = '/captcha/challenge';

    public function testBackofficeChallengeEndpointIsPublic(): void
    {
        // Arrange
        $securityGuiConfig = new SecurityGuiConfig();

        // Act
        $isPublic = $this->matchesPath((string)$securityGuiConfig->getIgnorablePaths(), static::BACKOFFICE_CHALLENGE_PATH);

        // Assert
        $this->assertTrue($isPublic);
    }

    /**
     * @dataProvider provideBackofficePathsBesideTheChallengeEndpoint
     */
    public function testBackofficePathsBesideTheChallengeEndpointAreNotPublic(string $path): void
    {
        // Arrange
        $securityGuiConfig = new SecurityGuiConfig();

        // Act
        $isPublic = $this->matchesPath((string)$securityGuiConfig->getIgnorablePaths(), $path);

        // Assert
        $this->assertFalse($isPublic);
    }

    /**
     * @return array<string, list<string>>
     */
    public static function provideBackofficePathsBesideTheChallengeEndpoint(): array
    {
        return [
            'longer path' => ['/captcha/challenge-history'],
            'path below the endpoint' => ['/captcha/challenge/other-action'],
        ];
    }

    protected function matchesPath(string $pattern, string $path): bool
    {
        return (new PathRequestMatcher($pattern))->matches(Request::create($path));
    }
}
