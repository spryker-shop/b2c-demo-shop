<?php

namespace Pyz\Zed\ContactUs\Persistence;


use Generated\Shared\Transfer\PyzContactUsEntityTransfer;
use Spryker\Zed\Kernel\Persistence\AbstractEntityManager;

class ContactUsEntityManager extends AbstractEntityManager implements ContactUsEntityManagerInterface
{
    /**
     * @param PyzContactUsEntityTransfer $contactUsTransfer
     * @return PyzContactUsEntityTransfer|\Spryker\Shared\Kernel\Transfer\EntityTransferInterface
     */
    public function saveContactUs(PyzContactUsEntityTransfer $contactUsTransfer): PyzContactUsEntityTransfer
    {
        return $this->save($contactUsTransfer);
    }
}
