<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\HelloSpryker\Business;

use Generated\Shared\Transfer\PyzContactUsEntityTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \Pyz\Zed\HelloSpryker\Business\HelloSprykerBusinessFactory getFactory()
 * @method \Pyz\Zed\HelloSpryker\Persistence\HelloSprykerRepositoryInterface getRepository()
 * @method \Pyz\Zed\HelloSpryker\Persistence\HelloSprykerEntityManagerInterface getEntityManager()
 */
class HelloSprykerFacade extends AbstractFacade implements HelloSprykerFacadeInterface
{
    /**
     * @return \Generated\Shared\Transfer\PyzContactUsEntityTransfer
     */
    public function getContactUsData()
    {
        return $this->getFactory()
            ->createContactUsReader()
            ->getContactUsData();
    }

    /**
     * @param \Generated\Shared\Transfer\PyzContactUsEntityTransfer $contactUsEntityTransfer
     * @return PyzContactUsEntityTransfer
     */
    public function saveContactUsData(\Generated\Shared\Transfer\PyzContactUsEntityTransfer $contactUsEntityTransfer)
    {
       return $this->getFactory()
            ->createContactUsWriter()
            ->save($contactUsEntityTransfer);
    }
}
