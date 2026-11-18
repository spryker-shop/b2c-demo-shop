<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace PyzTest\Zed\Acl\Communication;

use Codeception\Test\Unit;
use Pyz\Zed\Acl\AclConfig;

/**
 * Auto-generated group annotations
 *
 * @group PyzTest
 * @group Zed
 * @group Acl
 * @group Communication
 * @group AclConfigTest
 * Add your own group annotations below this line
 */
class AclConfigTest extends Unit
{
    public function testGetRulesAllowsTheBackofficeCaptchaChallengeEndpoint(): void
    {
        // Arrange
        $aclConfig = new AclConfig();

        // Act
        $rules = $aclConfig->getRules();

        // Assert
        $this->assertContains(
            [
                'bundle' => 'captcha',
                'controller' => 'challenge',
                'action' => 'index',
                'type' => 'allow',
            ],
            $rules,
        );
    }
}
