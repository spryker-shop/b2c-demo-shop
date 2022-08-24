<?php

namespace Pyz\Zed\Faq\Communication;

use Generated\Shared\Transfer\FaqTransfer;
use Generated\Shared\Transfer\MoonTransfer;
use Generated\Shared\Transfer\PlanetTransfer;
use Orm\Zed\Planet\Persistence\PyzFaqQuery;
use Orm\Zed\Planet\Persistence\PyzMoonQuery;
use Orm\Zed\Planet\Persistence\PyzPlanetQuery;
use Pyz\Zed\Faq\Communication\Form\FaqForm;
use Pyz\Zed\Faq\Communication\Table\FaqTable;
use Pyz\Zed\Faq\FaqDependencyProvider;
use Pyz\Zed\Planet\Communication\Form\MoonForm;
use Pyz\Zed\Planet\Communication\Form\PlanetForm;
use Pyz\Zed\Planet\Communication\Table\MoonTable;
use Pyz\Zed\Planet\Communication\Table\PlanetTable;
use Pyz\Zed\Planet\PlanetDependencyProvider;
use Spryker\Zed\Kernel\Communication\AbstractCommunicationFactory;
use Symfony\Component\Form\FormInterface;

class FaqCommunicationFactory extends AbstractCommunicationFactory {

    public function __construct() { }

    /**
     * @return \Pyz\Zed\Planet\Communication\Table\PlanetTable
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException
     */
    public function createFaqTable(): FaqTable {
        return new FaqTable(
            $this->getFaqQuery(),
        );
    }

    /**
     * @return PyzFaqQuery
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException
     */
    private function getFaqQuery(): PyzFaqQuery {
        return $this->getProvidedDependency(FaqDependencyProvider::QUERY_FAQ);
    }


    /**
     * @param \Generated\Shared\Transfer\PlanetTransfer|null $planetTransfer
     * @param array $options
     *
     * @return \Symfony\Component\Form\FormInterface
     */
    public function createFaqForm(?FaqTransfer $trans = null, array $options = []): FormInterface {
        return $this->getFormFactory()->create(
            FaqForm::class,
            $trans,
            $options
        );
    }
}
