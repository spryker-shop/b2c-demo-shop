<?php

namespace Pyz\Zed\DeveloperGui\Communication;

use Pyz\Zed\Developer\Business\DeveloperFacadeInterface;
use Pyz\Zed\Developer\Persistence\DeveloperQueryContainerInterface;
use Pyz\Zed\DeveloperGui\Communication\Form\DataProvider\DeveloperEditFormDataProvider;
use Pyz\Zed\DeveloperGui\Communication\Form\DeveloperFormAdd;
use Pyz\Zed\DeveloperGui\Communication\Form\DeveloperFormDelete;
use Pyz\Zed\DeveloperGui\Communication\Form\DeveloperFormEdit;
use Pyz\Zed\DeveloperGui\Communication\Table\DeveloperTable;
use Pyz\Zed\DeveloperGui\Communication\Tabs\DeveloperFormTabs;
use Pyz\Zed\DeveloperGui\DeveloperGuiDependencyProvider;
use Spryker\Zed\Glossary\Business\GlossaryFacadeInterface;
use Spryker\Zed\Gui\Communication\Table\AbstractTable;
use Spryker\Zed\Kernel\Communication\AbstractCommunicationFactory;
use Symfony\Component\Form\FormInterface;

class DeveloperGuiCommunicationFactory extends AbstractCommunicationFactory
{

    /**
     * @return DeveloperQueryContainerInterface
     */
    public function getDeveloperQueryContainer(): DeveloperQueryContainerInterface
    {
        return $this->getProvidedDependency(DeveloperGuiDependencyProvider::QUERY_CONTAINER_DEVELOPER);
    }

    /**
     * @return GlossaryFacadeInterface
     */
    public function getGlossaryFacade(): GlossaryFacadeInterface
    {
        return $this->getProvidedDependency(DeveloperGuiDependencyProvider::FACADE_GLOSSARY);
    }

    /**
     * @return AbstractTable
     */
    public function createDeveloperTable(): AbstractTable
    {
        return new DeveloperTable(
            $this->getDeveloperQueryContainer(),
            $this->getGlossaryFacade()
        );
    }

    /**
     * @param array $formData
     * @param array $options
     *
     * @return FormInterface
     */
    public function getDeveloperAddForm(array $formData = [], array $options = []): FormInterface
    {
        return $this->getFormFactory()->create(DeveloperFormAdd::class, $formData, $options);
    }

    /**
     * @return DeveloperFacadeInterface
     */
    public function getDeveloperFacade(): DeveloperFacadeInterface
    {
        return $this->getProvidedDependency(DeveloperGuiDependencyProvider::FACADE_DEVELOPER);

    }

    /**
     * @return DeveloperEditFormDataProvider
     */
    public function createDeveloperEditFormDataProvider(): DeveloperEditFormDataProvider
    {
        return new DeveloperEditFormDataProvider(
            $this->getDeveloperFacade()
        );
    }

    /**
     * @param array $formData
     * @param array $options
     *
     * @return FormInterface
     */
    public function getDeveloperEditForm(array $formData = [], array $options = []): FormInterface
    {
        return $this->getFormFactory()->create(DeveloperFormEdit::class, $formData, $options);
    }

    /**
     * @return FormInterface
     */
    public function getDeveloperDeleteForm(): FormInterface
    {
        return $this->getFormFactory()->create(DeveloperFormDelete::class);
    }

    /**
     * @return DeveloperFormTabs
     */
    public function createDeveloperFormTabs(): DeveloperFormTabs
    {
        return new DeveloperFormTabs();
    }

}
