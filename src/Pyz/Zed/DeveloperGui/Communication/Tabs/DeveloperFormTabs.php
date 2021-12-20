<?php

namespace Pyz\Zed\DeveloperGui\Communication\Tabs;

use Generated\Shared\Transfer\TabItemTransfer;
use Generated\Shared\Transfer\TabsViewTransfer;
use Spryker\Zed\Gui\Communication\Tabs\AbstractTabs;

class DeveloperFormTabs extends AbstractTabs
{
    protected const DEVELOPER_TAB_NAME = 'developers';
    protected const DEVELOPER_TAB_LABEL = 'Developer';

    /**
     * @param TabsViewTransfer $tabsViewTransfer
     *
     * @return TabsViewTransfer
     */
    protected function build(TabsViewTransfer $tabsViewTransfer): TabsViewTransfer
    {
        $tabsViewTransfer = $this->addDeveloperFormTabs($tabsViewTransfer);
        $tabsViewTransfer = $this->setFooter($tabsViewTransfer);

        return $tabsViewTransfer;
    }

    /**
     * @param TabsViewTransfer $tabsViewTransfer
     *
     * @return TabsViewTransfer
     */
    protected function addDeveloperFormTabs(TabsViewTransfer $tabsViewTransfer): TabsViewTransfer
    {
        $tabsViewTransfer->addTab($this->createDeveloperTab());;

        return $tabsViewTransfer;
    }

    /**
     * @return TabItemTransfer
     */
    protected function createDeveloperTab(): TabItemTransfer
    {
        $tabItemTransfer = new TabItemTransfer();
        $tabItemTransfer->setName(static::DEVELOPER_TAB_NAME);
        $tabItemTransfer->setTitle(static::DEVELOPER_TAB_LABEL);
        $tabItemTransfer->setTemplate('@DeveloperGui/_partials/developer-tab.twig');

        return $tabItemTransfer;
    }

    /**
     * @param TabsViewTransfer $tabsViewTransfer
     *
     * @return TabsViewTransfer
     */
    protected function setFooter(TabsViewTransfer $tabsViewTransfer): TabsViewTransfer
    {
        return $tabsViewTransfer
            ->setFooterTemplate('@DeveloperGui/_partials/tabs-footer.twig')
            ->setIsNavigable(true);
    }

}
