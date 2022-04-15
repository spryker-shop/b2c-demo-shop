<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Pyz\Zed\CmsSlotGui\Communication;

use Pyz\Zed\CmsSlotGui\Communication\Table\PyzSlotTable;
use Spryker\Zed\CmsSlotGui\Communication\Table\SlotTable;
use Spryker\Zed\CmsSlotGui\Communication\CmsSlotGuiCommunicationFactory as SprykerCmsSlotGuiCommunicationFactory;

class CmsSlotGuiCommunicationFactory extends SprykerCmsSlotGuiCommunicationFactory
{
    /**
     * @param int|null $idSlotTemplate
     *
     * @return \Spryker\Zed\CmsSlotGui\Communication\Table\SlotTable
     */
    public function createSlotListTable(?int $idSlotTemplate = null): SlotTable
    {
        return new PyzSlotTable(
            $this->getCmsSlotQuery(),
            $this->getTranslatorFacade(),
            $idSlotTemplate
        );
    }
}
