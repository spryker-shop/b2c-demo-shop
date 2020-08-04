<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace PyzTest\Zed\NavigationGui;

use Codeception\Actor;
use Codeception\Scenario;
use Generated\Shared\Transfer\NavigationTransfer;
use Generated\Shared\Transfer\NavigationTreeNodeTransfer;
use Generated\Shared\Transfer\NavigationTreeTransfer;
use Orm\Zed\Navigation\Persistence\SpyNavigation;
use Orm\Zed\Navigation\Persistence\SpyNavigationQuery;

/**
 * Inherited Methods
 *
 * @method void wantToTest($text)
 * @method void wantTo($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method \Codeception\Lib\Friend haveFriend($name, $actorClass = NULL)
 *
 * @SuppressWarnings(PHPMD)
 */
class NavigationGuiPresentationTester extends Actor
{
    use _generated\NavigationGuiPresentationTesterActions;

    public const ROOT_NODE_ANCHOR_SELECTOR = '#navigation-node-0_anchor';
    public const CHILD_NODE_ANCHOR_SELECTOR = '#navigation-node-%d_anchor';
    public const NAVIGATION_NODE_SELECTOR = '.jstree-node';
    public const NAVIGATION_TREE_SELECTOR = '#navigation-tree';
    public const NAVIGATION_TREE_SAVE_BUTTON_SELECTOR = '#navigation-tree-save-btn';
    public const REMOVE_NODE_BUTTON_SELECTOR = '#remove-selected-node-btn';
    public const ADD_CHILD_NODE_BUTTON_SELECTOR = '#add-child-node-btn';
    public const LOCALIZED_FORM_CONTAINER_SELECTOR = '#localized_attributes_container-%s .collapse-link';
    public const NODE_CHILD_SELECTOR = '#navigation-node-%d #navigation-node-%d';
    public const NODE_NAME_CHILD_SELECTOR = "//*[@id=\"navigation-node-%d\"]//*[text()[contains(.,'%s')]]";
    public const NODE_FORM_IFRAME_NAME = 'navigation-node-form-iframe';
    public const SUCCESS_MESSAGE_SELECTOR = '.flash-messages .alert-success';
    public const SWEET_ALERT_SELECTOR = '.sweet-alert';
    public const SWEET_ALERT_CONFIRM_SELECTOR = '.sweet-alert button.confirm';
    public const NODE_FORM_SELECTOR = 'form';
    public const NODE_UPDATE_FORM_SELECTOR = '//form[@name="navigation_node"]';
    public const FLASH_MESSAGES_SELECTOR = '//div[@class="flash-messages"]/div';
    public const NAVIGATION_DELETE_FORM_SELECTOR = '//*[@id="navigation-table"]/tbody/tr/td[5]/form[1]';
    public const NAVIGATION_ROW_ACTIVE_LINK_SELECTOR = '//*[@id="navigation-table"]/tbody/tr[1]/td[5]/a[2]';

    /**
     * @param \Codeception\Scenario $scenario
     */
    public function __construct(Scenario $scenario)
    {
        parent::__construct($scenario);

        $this->amZed();
        $this->amLoggedInUser();
    }

    /**
     * @param string $value
     *
     * @return void
     */
    public function setNameField($value)
    {
        $this->fillField('//*[@id="navigation_name"]', $value);
    }

    /**
     * @param string $value
     *
     * @return void
     */
    public function setKeyField($value)
    {
        $this->fillField('//*[@id="navigation_key"]', $value);
    }

    /**
     * @param bool $checked
     *
     * @return void
     */
    public function checkIsActiveField($checked)
    {
        if ($checked) {
            $this->checkOption('//*[@id="navigation_is_active"]');
        } else {
            $this->uncheckOption('//*[@id="navigation_is_active"]');
        }
    }

    /**
     * @return void
     */
    public function submitNavigationForm()
    {
        $this->click('//*[@id="navigation-save-btn"]');
    }

    /**
     * @return void
     */
    public function submitDeleteNavigationForm(): void
    {
        $this->click('//*[@id="delete_navigation_form_submit"]');
    }

    /**
     * @param string $pattern
     * @param string $value
     *
     * @return void
     */
    public function seeMatches($pattern, $value)
    {
        $this->assertRegExp($pattern, $value);
    }

    /**
     * @return void
     */
    public function clickEditFirstRowInList()
    {
        $this->click('//*[@id="navigation-table"]/tbody/tr[1]/td[5]/a');
    }

    /**
     * @param string $expectedMessagePattern
     *
     * @return int
     */
    public function seeSuccessMessage($expectedMessagePattern)
    {
        $this->waitForElement(static::FLASH_MESSAGES_SELECTOR, 30);
        $successMessage = $this->grabTextFrom(static::FLASH_MESSAGES_SELECTOR);
        $this->seeMatches($expectedMessagePattern, $successMessage);

        preg_match($expectedMessagePattern, $successMessage, $matches);

        return $matches[1];
    }

    /**
     * @return void
     */
    public function activateFirstNavigationRow()
    {
        $this->click(static::NAVIGATION_ROW_ACTIVE_LINK_SELECTOR);
    }

    /**
     * @return void
     */
    public function deleteFirstNavigationRow()
    {
        $this->submitForm(static::NAVIGATION_DELETE_FORM_SELECTOR, []);
    }

    /**
     * @return int
     */
    public function prepareTestNavigationEntity()
    {
        $navigationEntity = new SpyNavigation();
        $navigationEntity
            ->setName('Acceptance navigation (2)')
            ->setKey('acceptance2')
            ->setIsActive(true)
            ->save();

        return $navigationEntity->getIdNavigation();
    }

    /**
     * @param string $localeName
     *
     * @return void
     */
    public function expandLocalizedForm($localeName)
    {
        $this->click(sprintf(self::LOCALIZED_FORM_CONTAINER_SELECTOR, $localeName));
    }

    /**
     * @return void
     */
    public function clickRootNode()
    {
        $this->click(self::ROOT_NODE_ANCHOR_SELECTOR);
    }

    /**
     * @param int $idNavigationNode
     *
     * @return void
     */
    public function clickNode($idNavigationNode)
    {
        $this->click(sprintf(self::CHILD_NODE_ANCHOR_SELECTOR, $idNavigationNode));
    }

    /**
     * @return void
     */
    public function waitForNavigationTree()
    {
        $this->waitForElement(self::NAVIGATION_TREE_SELECTOR);
        $this->wait(5);
    }

    /**
     * @param int $count
     *
     * @return void
     */
    public function seeNumberOfNavigationNodes($count)
    {
        $this->seeNumberOfElements(self::NAVIGATION_NODE_SELECTOR, $count);
    }

    /**
     * @param int $idParentNavigationNode
     * @param int $idChildNavigationNode
     *
     * @return void
     */
    public function seeNavigationNodeHierarchy($idParentNavigationNode, $idChildNavigationNode)
    {
        $this->waitForElement(sprintf(
            self::NODE_CHILD_SELECTOR,
            $idParentNavigationNode,
            $idChildNavigationNode
        ));
    }

    /**
     * @param int $idParentNavigationNode
     * @param string $childNavigationNodeName
     *
     * @return void
     */
    public function seeNavigationNodeHierarchyByChildNodeName($idParentNavigationNode, $childNavigationNodeName)
    {
        $this->seeElement(sprintf(
            self::NODE_NAME_CHILD_SELECTOR,
            $idParentNavigationNode,
            $childNavigationNodeName
        ));
    }

    /**
     * @param int $idNavigationNode
     * @param int $idTargetNavigationNode
     *
     * @return void
     */
    public function moveNavigationNode($idNavigationNode, $idTargetNavigationNode)
    {
        $this->dragAndDrop(
            sprintf(self::CHILD_NODE_ANCHOR_SELECTOR, $idNavigationNode),
            sprintf(self::CHILD_NODE_ANCHOR_SELECTOR, $idTargetNavigationNode)
        );
    }

    /**
     * @return void
     */
    public function saveNavigationTreeOrder()
    {
        $this->click(self::NAVIGATION_TREE_SAVE_BUTTON_SELECTOR);
    }

    /**
     * @param string $message
     *
     * @return void
     */
    public function seeSuccessfulOrderSaveMessage($message)
    {
        $this->waitForElement(self::SWEET_ALERT_SELECTOR, 5);
        $this->wait(1);
        $this->see($message);
        $this->click(self::SWEET_ALERT_CONFIRM_SELECTOR);
    }

    /**
     * @return void
     */
    public function switchToNodeForm()
    {
        $this->switchToIFrame(self::NODE_FORM_IFRAME_NAME);
        $this->waitForElement(self::NODE_FORM_SELECTOR, 5);
    }

    /**
     * @return void
     */
    public function switchToNavigationTree()
    {
        $this->switchToIFrame();
        $this->waitForNavigationTree();
    }

    /**
     * @return void
     */
    public function clickRemoveNodeButton()
    {
        $this->click(self::REMOVE_NODE_BUTTON_SELECTOR);
    }

    /**
     * @return void
     */
    public function clickAddChildNodeButton()
    {
        $this->click(self::ADD_CHILD_NODE_BUTTON_SELECTOR);
    }

    /**
     * @param string $title
     *
     * @return void
     */
    public function submitCreateNodeFormWithoutType($title)
    {
        $this->submitForm(self::NODE_FORM_SELECTOR, [
            'navigation_node[navigation_node_localized_attributes][0][title]' => $title,
            'navigation_node[navigation_node_localized_attributes][1][title]' => $title,
            'navigation_node[is_active]' => true,
        ]);
    }

    /**
     * @param string $title
     * @param string $externalUrl
     *
     * @return void
     */
    public function submitCreateNodeFormWithExternalUrlType($title, $externalUrl)
    {
        $this->submitForm(self::NODE_FORM_SELECTOR, [
            'navigation_node[node_type]' => 'external_url',
            'navigation_node[navigation_node_localized_attributes][0][external_url]' => $externalUrl,
            'navigation_node[navigation_node_localized_attributes][1][external_url]' => $externalUrl,
            'navigation_node[navigation_node_localized_attributes][0][title]' => $title,
            'navigation_node[navigation_node_localized_attributes][1][title]' => $title,
            'navigation_node[is_active]' => true,
        ]);
    }

    /**
     * @param string $categoryUrl_en_US
     * @param string $categoryUrl_de_DE
     *
     * @return void
     */
    public function submitUpdateNodeToCategoryType($categoryUrl_en_US, $categoryUrl_de_DE)
    {
        $this->submitForm(static::NODE_UPDATE_FORM_SELECTOR, [
            'navigation_node[node_type]' => 'category',
            'navigation_node[navigation_node_localized_attributes][0][category_url]' => $categoryUrl_en_US,
            'navigation_node[navigation_node_localized_attributes][1][category_url]' => $categoryUrl_de_DE,
        ]);
    }

    /**
     * @param string $title
     * @param string $cmsPageUrl_en_US
     * @param string $cmsPageUrl_de_DE
     *
     * @return void
     */
    public function submitCreateNodeFormWithCmsPageType($title, $cmsPageUrl_en_US, $cmsPageUrl_de_DE)
    {
        $this->submitForm(self::NODE_FORM_SELECTOR, [
            'navigation_node[node_type]' => 'cms_page',
            'navigation_node[navigation_node_localized_attributes][0][title]' => $title,
            'navigation_node[navigation_node_localized_attributes][0][cms_page_url]' => $cmsPageUrl_en_US,
            'navigation_node[navigation_node_localized_attributes][1][title]' => $title,
            'navigation_node[navigation_node_localized_attributes][1][cms_page_url]' => $cmsPageUrl_de_DE,
            'navigation_node[is_active]' => true,
        ]);
    }

    /**
     * @param \Generated\Shared\Transfer\NavigationTreeTransfer $navigationTreeTransfer
     *
     * @return \Generated\Shared\Transfer\NavigationTreeTransfer
     */
    public function prepareTestNavigationTreeEntities(NavigationTreeTransfer $navigationTreeTransfer)
    {
        $navigationTransfer = $this->getLocator()->navigation()->facade()->createNavigation($navigationTreeTransfer->getNavigation());

        foreach ($navigationTreeTransfer->getNodes() as $navigationTreeNodeTransfer) {
            $this->createNavigationNodesRecursively($navigationTreeNodeTransfer, $navigationTransfer->getIdNavigation());
        }

        return $navigationTreeTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\NavigationTreeNodeTransfer $navigationTreeNodeTransfer
     * @param int $idNavigation
     * @param int|null $idParentNavigationNode
     *
     * @return void
     */
    protected function createNavigationNodesRecursively(NavigationTreeNodeTransfer $navigationTreeNodeTransfer, $idNavigation, $idParentNavigationNode = null)
    {
        $navigationNodeTransfer = $navigationTreeNodeTransfer->getNavigationNode();
        $navigationNodeTransfer
            ->setFkNavigation($idNavigation)
            ->setFkParentNavigationNode($idParentNavigationNode);

        $navigationNodeTransfer = $this->getLocator()->navigation()->facade()->createNavigationNode($navigationNodeTransfer);

        foreach ($navigationTreeNodeTransfer->getChildren() as $childNavigationTreeNodeTransfer) {
            $this->createNavigationNodesRecursively($childNavigationTreeNodeTransfer, $idNavigation, $navigationNodeTransfer->getIdNavigationNode());
        }
    }

    /**
     * @param string $locale
     *
     * @return int
     */
    public function getIdLocale($locale)
    {
        return $this->getLocator()->locale()->facade()->getLocale($locale)->getIdLocale();
    }

    /**
     * @param \Generated\Shared\Transfer\NavigationTreeTransfer $navigationTreeTransfer
     *
     * @return void
     */
    public function cleanUpNavigationTree(NavigationTreeTransfer $navigationTreeTransfer): void
    {
        $navigationEntity = $this->findNavigationByName($navigationTreeTransfer->getNavigation());

        if (!$navigationEntity) {
            return;
        }

        $navigationNodeEntities = $navigationEntity->getSpyNavigationNodes();

        foreach ($navigationNodeEntities as $navigationNodeEntity) {
            $navigationNodeEntity->getSpyNavigationNodeLocalizedAttributess()->delete();
        }

        $navigationNodeEntities->delete();
        $navigationEntity->delete();
    }

    /**
     * @param \Generated\Shared\Transfer\NavigationTransfer $navigationTransfer
     *
     * @return \Orm\Zed\Navigation\Persistence\SpyNavigation|null
     */
    protected function findNavigationByName(NavigationTransfer $navigationTransfer): ?SpyNavigation
    {
        $navigationEntity = (new SpyNavigationQuery())
            ->joinWithSpyNavigationNode()
            ->useSpyNavigationNodeQuery()
            ->joinWithSpyNavigationNodeLocalizedAttributes()
            ->endUse()
            ->findByName(
                $navigationTransfer->getName()
            )->getFirst();

        return $navigationEntity;
    }

    /**
     * @param array $data
     *
     * @return void
     */
    public function submitCreateNodeFormWithCmsPageTypeWithFormData(array $data): void
    {
        $formData = [
            'navigation_node[node_type]' => 'cms_page',
            'navigation_node[is_active]' => true,
        ];
        foreach ($data as $index => $localizedData) {
            $titleKey = sprintf('navigation_node[navigation_node_localized_attributes][%s][title]', $index);
            $urlKey = sprintf('navigation_node[navigation_node_localized_attributes][%s][cms_page_url]', $index);
            $formData[$titleKey] = $localizedData['title'];
            $formData[$urlKey] = $localizedData['url'];
        }
        $this->submitForm(static::NODE_FORM_SELECTOR, $formData);
    }

    /**
     * @param string $defaultSlug
     * @param string[] $localizedSlugs
     *
     * @return array
     */
    public function generateUrlByAvailableLocaleTransfers(string $defaultSlug, array $localizedSlugs): array
    {
        $localeTransfers = $this->getLocator()->locale()->facade()->getLocaleCollection();
        $localeUrls = [];
        foreach ($localeTransfers as $localeTransfer) {
            $localePrefix = substr($localeTransfer->getLocaleName(), 0, 2);
            $localeUrls[] = sprintf('/%s/%s', $localePrefix, $localizedSlugs[$localeTransfer->getLocaleName()] ?? $defaultSlug);
        }

        return $localeUrls;
    }
}
