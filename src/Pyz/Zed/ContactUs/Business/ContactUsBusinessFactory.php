<?php

namespace Pyz\Zed\ContactUs\Business;

use Pyz\Zed\ContactUs\Business\Reader\ContactUsReader;
use Pyz\Zed\ContactUs\Business\Reader\ContactUsReaderInterface;
use Pyz\Zed\ContactUs\Business\Writer\ContactUsWriter;
use Pyz\Zed\ContactUs\Business\Writer\ContactUsWriterInterface;
use Pyz\Zed\ContactUs\Persistence\ContactUsEntityManagerInterface;
use Pyz\Zed\ContactUs\Persistence\ContactUsRepositoryInterface;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

/**
 * Class ContactUsBusinessFactory
 * @package Pyz\Zed\ContactUs\Business
 *
 * @method ContactUsEntityManagerInterface getEntityManager()
 * @method ContactUsRepositoryInterface getRepository()
 */
class ContactUsBusinessFactory extends AbstractBusinessFactory
{
    public function createReader(): ContactUsReaderInterface
    {
        return new ContactUsReader($this->getRepository());
    }

    public function createWriter(): ContactUsWriterInterface
    {
        return new ContactUsWriter($this->getEntityManager());
    }
}
