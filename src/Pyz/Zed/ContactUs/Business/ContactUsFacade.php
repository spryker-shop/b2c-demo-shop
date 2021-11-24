<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\ContactUs\Business;

use Generated\Shared\Transfer\ContactUsTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * Class ContactUsFacade
 *
 * @package Pyz\Zed\ContactUs\Business
 *
 * @method \Pyz\Zed\ContactUs\Business\ContactUsBusinessFactory getFactory()
 * @method \Pyz\Zed\ContactUs\Persistence\ContactUsRepositoryInterface getRepository()
 * @method \Pyz\Zed\ContactUs\Persistence\ContactUsEntityManagerInterface getEntityManager()
 */
class ContactUsFacade extends AbstractFacade implements ContactUsFacadeInterface
{
    public function getContactUsMessages(): array
    {
        return $this->getFactory()->createReader()->getContactUsMessages();
    }

    public function findContactUsById(int $contactUsId): ?ContactUsTransfer
    {
        return $this->getFactory()->createReader()->findContactUsById($contactUsId);
    }

    public function saveContactUs(ContactUsTransfer $contactUsTransfer): ContactUsTransfer
    {
        return $this->getFactory()->createWriter()->saveContactUs($contactUsTransfer);
    }
}
