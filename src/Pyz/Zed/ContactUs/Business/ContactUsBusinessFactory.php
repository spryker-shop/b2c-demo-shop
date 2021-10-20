<?php

namespace Pyz\Zed\ContactUs\Business;

use Pyz\Zed\ContactUs\Business\ContactUsReader\ContactUsReader;
use Pyz\Zed\ContactUs\Business\ContactUsReader\ContactUsReaderInterface;
use Pyz\Zed\ContactUs\Business\ContactUsWriter\ContactUsWriter;
use Pyz\Zed\ContactUs\Business\ContactUsWriter\ContactUsWriterInterface;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

/**
 * @method \Pyz\Zed\ContactUs\Persistence\ContactUsRepositoryInterface getRepository()
 * @method \Pyz\Zed\ContactUs\Persistence\ContactUsEntityManagerInterface getEntityManager()()
 * @method \Pyz\Zed\ContactUs\ContactUsConfig getConfig()
 */
class ContactUsBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return ContactUsReaderInterface
     */
    public function createContactUsReader(): ContactUsReaderInterface
    {
        return new ContactUsReader($this->getRepository());
    }

    /**
     * @return ContactUsWriterInterface
     */
    public function createContactUsWriter(): ContactUsWriterInterface
    {
        return new ContactUsWriter($this->getEntityManager());
    }
}
