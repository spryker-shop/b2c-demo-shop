<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Newsletter;

use Spryker\Shared\Newsletter\NewsletterConstants;
use Spryker\Zed\Newsletter\NewsletterConfig as SprykerNewsletterConfig;

class NewsletterConfig extends SprykerNewsletterConfig
{
    /**
     * @return array<string>
     */
    public function getNewsletterTypes(): array
    {
        return [
            NewsletterConstants::DEFAULT_NEWSLETTER_TYPE,
        ];
    }
}
