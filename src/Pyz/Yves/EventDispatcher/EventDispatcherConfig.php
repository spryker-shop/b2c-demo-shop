<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Pyz\Yves\EventDispatcher;

use ESpirit\Shared\FirstSpiritPreview\FirstSpiritPreviewConstants;
use Spryker\Yves\EventDispatcher\EventDispatcherConfig as SprykerEventDispatcherConfig;

class EventDispatcherConfig extends SprykerEventDispatcherConfig
{
    /**
     * @return string
     */
    public function getPreviewToken(): string
    {
        return $this->get(FirstSpiritPreviewConstants::FIRSTSPIRIT_PREVIEW_AUTHENTICATION_INIT_TOKEN, '');
    }
}
