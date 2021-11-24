<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Client\ContactUs;

use Generated\Shared\Transfer\ContactUsTransfer;
use Spryker\Client\Kernel\AbstractClient;

/**
 * Class ContactUsClient
 *
 * @package Pyz\Client\ContactUs
 *
 * @method \Pyz\Client\ContactUs\ContactUsFactory getFactory()
 */
class ContactUsClient extends AbstractClient implements ContactUsClientInterface
{
    public function addContactUsFeedback(ContactUsTransfer $contactUsTransfer): ContactUsTransfer
    {
        return $this->getFactory()->createContactUsZedStub()->addContactUsFeedback($contactUsTransfer);
    }
}
