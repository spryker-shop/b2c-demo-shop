<?php


namespace Pyz\Client\ContactUs;


use Generated\Shared\Transfer\ContactUsTransfer;
use Spryker\Client\Kernel\AbstractClient;

/**
 * Class ContactUsClient
 * @package Pyz\Client\ContactUs
 *
 * @method ContactUsFactory getFactory()
 */
class ContactUsClient extends AbstractClient implements ContactUsClientInterface
{
    public function addContactUsFeedback(ContactUsTransfer $contactUsTransfer): ContactUsTransfer
    {
        return $this->getFactory()->createContactUsZedStub()->addContactUsFeedback($contactUsTransfer);
    }
}
