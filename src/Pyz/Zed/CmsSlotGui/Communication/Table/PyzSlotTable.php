<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Pyz\Zed\CmsSlotGui\Communication\Table;

use Spryker\Zed\CmsSlotGui\Communication\Table\SlotTable as SprykerSlotTable;

class PyzSlotTable extends SprykerSlotTable
{
    /**
     * @return bool
     */
    protected function isContentProviderColumnVisible(): bool
    {
        if ($this->contentProviderTypesNumber === null) {
            $this->contentProviderTypesNumber = (clone $this->cmsSlotQuery)
                ->select(static::COL_CONTENT_PROVIDER)
                ->distinct()
                ->count();
        }

        return $this->contentProviderTypesNumber > 1;
    }
}
