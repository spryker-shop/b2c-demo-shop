<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\ContactUs\Business;

use Pyz\Zed\ContactUs\Business\Reader\ContactUsReader;
use Pyz\Zed\ContactUs\Business\Reader\ContactUsReaderInterface;
use Pyz\Zed\ContactUs\Business\Writer\ContactUsWriter;
use Pyz\Zed\ContactUs\Business\Writer\ContactUsWriterInterface;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

/**
 * Class ContactUsBusinessFactory
 *
 * @package Pyz\Zed\ContactUs\Business
 *
 * @method \Pyz\Zed\ContactUs\Persistence\ContactUsEntityManagerInterface getEntityManager()
 * @method \Pyz\Zed\ContactUs\Persistence\ContactUsRepositoryInterface getRepository()
 * @method \Pyz\Zed\ContactUs\ContactUsConfig getConfig()
 * @method \Pyz\Zed\ContactUs\Persistence\ContactUsQueryContainerInterface getQueryContainer()
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
