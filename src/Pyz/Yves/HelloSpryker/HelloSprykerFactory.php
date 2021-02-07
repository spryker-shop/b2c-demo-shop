<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Yves\HelloSpryker;

use Pyz\Yves\HelloSpryker\Form\ContactUsFormType;
use Pyz\Zed\HelloSpryker\Business\HelloSprykerFacadeInterface;
use Spryker\Shared\Application\ApplicationConstants;
use Spryker\Yves\Kernel\AbstractFactory;
use Symfony\Component\Form\FormFactory;

class HelloSprykerFactory extends AbstractFactory
{
    /**
     * @return \Symfony\Component\Form\FormInterface
     */
    public function createContactUsForm()
    {
        return $this->getFormFactory()->create(ContactUsFormType::class);
    }

    /**
     * @return \Symfony\Component\Form\FormFactory
     */
    public function getFormFactory(): FormFactory
    {
        return $this->getProvidedDependency(ApplicationConstants::FORM_FACTORY);
    }

    /**
     * @return \Pyz\Zed\HelloSpryker\Business\HelloSprykerFacadeInterface
     */
    public function getHelloSprykerFacade(): HelloSprykerFacadeInterface
    {
        return $this->getProvidedDependency(HelloSprykerDependencyProvider::FACADE_HELLO_SPRYKER);
    }
}
