<?php


namespace Pyz\Zed\ContactUs\Business;

use Spryker\Zed\Kernel\Business\AbstractFacade;
use Generated\Shared\Transfer\ContactUsTransfer;

/**
 * @method \Pyz\Zed\ContactUs\Persistence\ContactUsEntityManagerInterface getEntityManager()
 * @method \Pyz\Zed\ContactUs\Persistence\ContactUsRepositoryInterface getRepository()
 *
 */
class ContactUsFacade extends AbstractFacade implements ContactUsFacadeInterface
{
    /**
     * @param \Generated\Shared\Transfer\ContactUsTransfer $contactUsTransfer
     *
     * @return bool
     */
    public function saveContactUsData(ContactUsTransfer $contactUsTransfer): bool
    {
        return $this->getEntityManager()->saveContactUsEntity($contactUsTransfer);
    }

    /**
     * @return array
     */
    public function getContactUsData(): array
    {
        return $this->getRepository()->findPyzContactUs();
    }
}
