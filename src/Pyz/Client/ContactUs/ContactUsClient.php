<?php

namespace Pyz\Client\ContactUs;

use Generated\Shared\Transfer\ContactUsTransfer;
use Spryker\Client\Kernel\AbstractClient;

/**
 * @method \Pyz\Client\ContactUs\ContactUsFactory getFactory()
 */
class ContactUsClient extends AbstractClient implements ContactUsClientInterface
{
    /**
     * @param ContactUsTransfer $contactUsTransfer
     *
     * @return \Spryker\Shared\Kernel\Transfer\TransferInterface
     */
    public function addMessage(ContactUsTransfer $contactUsTransfer)
    {
        return $this->getFactory()
            ->createZedStub()
            ->addMessage($contactUsTransfer);
    }
}
