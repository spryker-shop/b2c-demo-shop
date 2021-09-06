<?php

namespace Pyz\Zed\ContactUs\Business;

use Pyz\Zed\ContactUs\Business\Reader\ContactReader;
use Pyz\Zed\ContactUs\Business\Reader\ContactReaderInterface;
use Pyz\Zed\ContactUs\Business\Writer\ContactUsWriter;
use Pyz\Zed\ContactUs\Business\Writer\ContactWriterInterface;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

/**
 * @method \Pyz\Zed\ContactUs\ContactUsConfig getConfig()
 * @method \Pyz\Zed\ContactUs\Persistence\ContactUsQueryContainerInterface getQueryContainer()
 * @method \Pyz\Zed\ContactUs\Persistence\ContactUsRepositoryInterface getRepository()
 * @method \Pyz\Zed\ContactUs\Persistence\ContactUsEntityManagerInterface getEntityManager()
 */
class ContactUsBusinessFactory extends AbstractBusinessFactory
{

    /**
     * @return ContactReaderInterface
     */
    public function createContactReader(): ContactReaderInterface
    {
        return new ContactReader(
            $this->getRepository()
        );
    }

    /**
     * @return ContactWriterInterface
     */
    public function createContactUsWriter():ContactWriterInterface
    {
        return new ContactUsWriter($this->getEntityManager());
    }

}
