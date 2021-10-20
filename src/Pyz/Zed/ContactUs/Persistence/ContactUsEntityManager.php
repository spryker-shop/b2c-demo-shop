<?php

namespace Pyz\Zed\ContactUs\Persistence;

use Generated\Shared\Transfer\PyzContactUsEntityTransfer;
use Spryker\Zed\Kernel\Persistence\AbstractEntityManager;
use Spryker\Zed\Kernel\Persistence\EntityManager\EntityManagerInterface;

class ContactUsEntityManager extends AbstractEntityManager implements ContactUsEntityManagerInterface, EntityManagerInterface
{
    /**
     * @api
     *
     * @param PyzContactUsEntityTransfer $blogEntityTransfer
     *
     * @return PyzContactUsEntityTransfer|\Spryker\Shared\Kernel\Transfer\EntityTransferInterface
     */
    public function saveContactUs(PyzContactUsEntityTransfer $blogEntityTransfer): PyzContactUsEntityTransfer
    {
        return $this->save($blogEntityTransfer);
    }
}
