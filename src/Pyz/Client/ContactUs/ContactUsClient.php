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
     */
    public function saveContactUs(ContactUsTransfer $contactUsTransfer)
    {
        $this->getFactory()
            ->createZedStub()
            ->saveContactUs($contactUsTransfer);
    }
}
