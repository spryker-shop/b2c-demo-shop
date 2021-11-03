<?php


namespace Pyz\Yves\ContactUs\Form\DataProvider;

use Generated\Shared\Transfer\ContactUsTransfer;

class ContactUsFormDataProvider
{
    /**
     *
     * @return array
     */
    public function getData(): array
    {
        $data = (new ContactUsTransfer())->toArray();

        return $data;
    }
}
