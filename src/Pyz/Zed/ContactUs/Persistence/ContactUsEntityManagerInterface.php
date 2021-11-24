<?php

namespace Pyz\Zed\ContactUs\Persistence;


use Generated\Shared\Transfer\PyzContactUsEntityTransfer;

interface ContactUsEntityManagerInterface
{
    /**
     * @param PyzContactUsEntityTransfer $contactUsTransfer
     * @return PyzContactUsEntityTransfer|\Spryker\Shared\Kernel\Transfer\EntityTransferInterface
     */
    public function saveContactUs(PyzContactUsEntityTransfer $contactUsTransfer): PyzContactUsEntityTransfer;
}
