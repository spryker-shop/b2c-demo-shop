<?php


namespace Pyz\Yves\ContactUs;

use Spryker\Yves\Kernel\AbstractBundleDependencyProvider;
use Spryker\Yves\Kernel\Container;

class ContactUsDependencyProvider extends AbstractBundleDependencyProvider
{
    public const CLIENT_CONTACT_US = 'CLIENT_CONTACT_US';

    public function provideDependencies(Container $container)
    {
        //$container = parent::provideDependencies($container);
        $container = $this->addContactUsClient($container);

        return $container;
    }

    protected function addContactUsClient(Container $container)
    {
        $container[self::CLIENT_CONTACT_US] = function(Container $container){
            return $container->getLocator()->contactUs()->client();
        };

        return $container;
    }
}
