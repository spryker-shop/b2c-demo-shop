<?php


namespace Pyz\Client\ContactUs\Zed;


use Generated\Shared\Transfer\ContactUsTransfer;
use Spryker\Client\ZedRequest\ZedRequestClientInterface;

class ContactUsZedStub implements ContactUsZedStubInterface
{
    /**
     * @var \Spryker\Client\ZedRequest\ZedRequestClientInterface
     */
    protected $zedRequestClient;

    /**
     * @param \Spryker\Client\ZedRequest\ZedRequestClientInterface $zedRequestClient
     */
    public function __construct(ZedRequestClientInterface $zedRequestClient)
    {
        $this->zedRequestClient = $zedRequestClient;
    }

    public function addContactUsFeedback(ContactUsTransfer $contactUsTransfer): ContactUsTransfer
    {
        /**
         * @var ContactUsTransfer $contactUsTransfer
         */
        $contactUsTransfer = $this->zedRequestClient->call(
            '/contact-us/gateway/add',
            $contactUsTransfer
        );

        return $contactUsTransfer;
    }
}
