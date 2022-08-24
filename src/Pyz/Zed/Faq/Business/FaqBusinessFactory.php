<?php

namespace Pyz\Zed\Faq\Business;

use Pyz\Zed\Faq\Business\Deleter\FaqDeleter;
use Pyz\Zed\Faq\Business\Deleter\FaqDeleterInterface;
use Pyz\Zed\Faq\Business\Reader\FaqReader;
use Pyz\Zed\Faq\Business\Reader\FaqReaderInterface;
use Pyz\Zed\Faq\Business\Updater\FaqUpdater;
use Pyz\Zed\Faq\Business\Updater\FaqUpdaterInterface;
use Pyz\Zed\Faq\Business\Writer\FaqWriter;
use Pyz\Zed\Faq\Business\Writer\FaqWriterInterface;
use Pyz\Zed\Faq\Persistence\FaqEntityManager;
use Pyz\Zed\Faq\Persistence\FaqRepository;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

/**
 * @method FaqEntityManager getEntityManager()
 * @method FaqRepository getRepository()
 */
class FaqBusinessFactory extends AbstractBusinessFactory {

    public function createFaqDeleter(): FaqDeleterInterface {

        return new FaqDeleter($this->getEntityManager());
    }

    public function createFaqUpdater(): FaqUpdaterInterface {

        return new FaqUpdater($this->getEntityManager());
    }

    public function createFaqWriter(): FaqWriterInterface {

        return new FaqWriter($this->getEntityManager());
    }

    public function createFaqReader(): FaqReaderInterface {

        return new FaqReader($this->getRepository());
    }
}
