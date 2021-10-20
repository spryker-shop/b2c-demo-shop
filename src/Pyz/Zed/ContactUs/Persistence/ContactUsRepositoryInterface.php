<?php

namespace Pyz\Zed\ContactUs\Persistence;

use Generated\Shared\Transfer\ContactUsTransfer;

interface ContactUsRepositoryInterface
{
    /**
     * @return \Orm\Zed\ContactUs\Persistence\PyzContactUs[]
     */
    public function getContactUsList(): array;
}
