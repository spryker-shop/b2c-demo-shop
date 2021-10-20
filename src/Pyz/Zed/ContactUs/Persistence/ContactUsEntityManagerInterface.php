<?php

namespace Pyz\Zed\ContactUs\Persistence;

use Generated\Shared\Transfer\PyzContactUsEntityTransfer;

interface ContactUsEntityManagerInterface
{
    public function saveContactUs(PyzContactUsEntityTransfer $blogEntityTransfer): PyzContactUsEntityTransfer;
}
