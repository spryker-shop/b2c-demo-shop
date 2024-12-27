<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace PyzTest\Zed\NavigationGui;

use Codeception\Actor;
use Exception;
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
 * @SuppressWarnings(\PyzTest\Zed\NavigationGui\PHPMD)
 */
class NavigationGuiPresentationTester extends Actor
{
    use _generated\NavigationGuiPresentationTesterActions;

    /**
     * @var string
     */
    public const ROOT_NODE_ANCHOR_SELECTOR = '#navigation-node-0_anchor';

    /**
     * @var string
     */
    public const CHILD_NODE_ANCHOR_SELECTOR = '#navigation-node-%d_anchor';

    /**
     * @var string
     */
    public const NAVIGATION_NODE_SELECTOR = '.jstree-node';

    /**
     * @var string
     */
    public const NAVIGATION_TREE_SELECTOR = '#navigation-tree';

    /**
     * @var string
     */
    public const NAVIGATION_TREE_SAVE_BUTTON_SELECTOR = '#navigation-tree-save-btn';

    /**
     * @var string
     */
    public const REMOVE_NODE_BUTTON_SELECTOR = '#remove-selected-node-btn';

    /**
     * @var string
     */
    public const ADD_CHILD_NODE_BUTTON_SELECTOR = '#add-child-node-btn';

    /**
     * @var string
     */
    public const LOCALIZED_FORM_CONTAINER_SELECTOR = '#localized_attributes_container-%s .collapse-link';

    /**
     * @var string
     */
    public const NODE_CHILD_SELECTOR = '#navigation-node-%d #navigation-node-%d';

    /**
     * @var string
     */
    public const NODE_NAME_CHILD_SELECTOR = "//*[@id=\"navigation-node-%d\"]//*[text()[contains(.,'%s')]]";

    /**
     * @var string
     */
    public const NODE_FORM_IFRAME_NAME = 'navigation-node-form-iframe';

    /**
     * @var string
     */
    public const SUCCESS_MESSAGE_SELECTOR = '.flash-messages .alert-success';

    /**
     * @var string
     */
    public const SWEET_ALERT_SELECTOR = '.sweet-alert';

    /**
     * @var string
     */
    public const SWEET_ALERT_CONFIRM_SELECTOR = '.sweet-alert button.confirm';

    /**
     * @var string
     */
    public const NODE_FORM_SELECTOR = 'form';

    /**
     * @var string
     */
    public const NODE_UPDATE_FORM_SELECTOR = '//form[@name="navigation_node"]';

    /**
     * @var string
     */
    public const FLASH_MESSAGE_TEXT_SELECTOR = '//div[@class="flash-messages"]/div';

    /**
     * @var string
     */
    public const NAVIGATION_DELETE_FORM_SELECTOR = '//*[@id="navigation-table"]/tbody/tr/td[5]/form[1]';

    /**
     * @var string
     */
    public const NAVIGATION_ROW_ACTIVE_LINK_SELECTOR = '//*[@id="navigation-table"]/tbody/tr[1]/td[5]/a[2]';

    /**
     * @param string $value
     *
     * @return void
     */
    public function setNameField(string $value): void
    {
        $this->fillField('//*[@id="navigation_name"]', $value);
    }

    /**
     * @param string $value
     *
     * @return void
     */
    public function setKeyField(string $value): void
    {
        $this->fillField('//*[@id="navigation_key"]', $value);
    }

    /**
     * @param bool $checked
     *
     * @return void
     */
    public function checkIsActiveField(bool $checked): void
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
    public function submitNavigationForm(): void
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
    public function seeMatches(string $pattern, string $value): void
    {
        $this->assertRegExp($pattern, $value);
    }

    /**
     * @return void
     */
    public function clickEditFirstRowInList(): void
    {
        $this->click('//*[@id="navigation-table"]/tbody/tr[1]/td[5]/a');
    }

    /**
     * @param string $expectedMessagePattern
     *
     * @return string
     */
    public function seeSuccessMessage(string $expectedMessagePattern): string
    {
        $this->waitForElementVisible(static::FLASH_MESSAGE_TEXT_SELECTOR, 90);
        $successMessage = $this->grabTextFrom(static::FLASH_MESSAGE_TEXT_SELECTOR);
        $this->seeMatches($expectedMessagePattern, $successMessage);

        preg_match($expectedMessagePattern, $successMessage, $matches);

        return $matches[1];
    }

    /**
     * @return void
     */
    public function activateFirstNavigationRow(): void
    {
        $this->click(static::NAVIGATION_ROW_ACTIVE_LINK_SELECTOR);
    }

    /**
     * @return void
     */
    public function deleteFirstNavigationRow(): void
    {
        $this->submitForm(static::NAVIGATION_DELETE_FORM_SELECTOR, []);
    }

    /**
     * @return int
     */
    public function prepareTestNavigationEntity(): int
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
    public function expandLocalizedForm(string $localeName): void
    {
        $this->click(sprintf(self::LOCALIZED_FORM_CONTAINER_SELECTOR, $localeName));
    }

    /**
     * @return void
     */
    public function clickRootNode(): void
    {
        $this->click(self::ROOT_NODE_ANCHOR_SELECTOR);
    }

    /**
     * @param int $idNavigationNode
     *
     * @return void
     */
    public function clickNode(int $idNavigationNode): void
    {
        $this->click(sprintf(self::CHILD_NODE_ANCHOR_SELECTOR, $idNavigationNode));
    }

    /**
     * @return void
     */
    public function waitForNavigationTree(): void
    {
        $this->waitForElement(self::NAVIGATION_TREE_SELECTOR);
        $this->wait(5);
    }

    /**
     * @param int $count
     *
     * @return void
     */
    public function seeNumberOfNavigationNodes(int $count): void
    {
        $this->seeNumberOfElements(self::NAVIGATION_NODE_SELECTOR, $count);
    }

    /**
     * @param int $idParentNavigationNode
     * @param int $idChildNavigationNode
     *
     * @return void
     */
    public function seeNavigationNodeHierarchy(int $idParentNavigationNode, int $idChildNavigationNode): void
    {
        $this->waitForElement(sprintf(
            self::NODE_CHILD_SELECTOR,
            $idParentNavigationNode,
            $idChildNavigationNode,
        ), 1);
    }

    /**
     * @param int $idParentNavigationNode
     * @param string $childNavigationNodeName
     *
     * @return void
     */
    public function seeNavigationNodeHierarchyByChildNodeName(int $idParentNavigationNode, string $childNavigationNodeName): void
    {
        $this->seeElement(sprintf(
            self::NODE_NAME_CHILD_SELECTOR,
            $idParentNavigationNode,
            $childNavigationNodeName,
        ));
    }

    /**
     * @param int $idNavigationNode
     * @param int $idTargetNavigationNode
     *
     * @return void
     */
    public function moveNavigationNode(int $idNavigationNode, int $idTargetNavigationNode): void
    {
        $this->dragAndDrop(
            sprintf(self::CHILD_NODE_ANCHOR_SELECTOR, $idNavigationNode),
            sprintf(self::CHILD_NODE_ANCHOR_SELECTOR, $idTargetNavigationNode),
        );
    }

    /**
     * @return void
     */
    public function saveNavigationTreeOrder(): void
    {
        $this->click(self::NAVIGATION_TREE_SAVE_BUTTON_SELECTOR);
    }

    /**
     * @param string $message
     *
     * @return void
     */
    public function seeSuccessfulOrderSaveMessage(string $message): void
    {
        $this->waitForElement(self::SWEET_ALERT_SELECTOR, 5);
        $this->wait(1);
        $this->see($message);
        $this->click(self::SWEET_ALERT_CONFIRM_SELECTOR);
    }

    /**
     * @return void
     */
    public function switchToNodeForm(): void
    {
        $this->switchToIFrame(self::NODE_FORM_IFRAME_NAME);
        $this->waitForElement(self::NODE_FORM_SELECTOR, 5);
    }

    /**
     * @return void
     */
    public function switchToNavigationTree(): void
    {
        $this->switchToIFrame();
        $this->waitForNavigationTree();
    }

    /**
     * @return void
     */
    public function clickRemoveNodeButton(): void
    {
        $this->click(self::REMOVE_NODE_BUTTON_SELECTOR);
    }

    /**
     * @return void
     */
    public function clickAddChildNodeButton(): void
    {
        $this->click(self::ADD_CHILD_NODE_BUTTON_SELECTOR);
    }

    /**
     * @param string $title
     *
     * @return void
     */
    public function submitCreateNodeFormWithoutType(string $title): void
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
    public function submitCreateNodeFormWithExternalUrlType(string $title, string $externalUrl): void
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
    public function submitUpdateNodeToCategoryType(string $categoryUrl_en_US, string $categoryUrl_de_DE): void
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
    public function submitCreateNodeFormWithCmsPageType(string $title, string $cmsPageUrl_en_US, string $cmsPageUrl_de_DE): void
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
    public function prepareTestNavigationTreeEntities(NavigationTreeTransfer $navigationTreeTransfer): NavigationTreeTransfer
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
    protected function createNavigationNodesRecursively(
        NavigationTreeNodeTransfer $navigationTreeNodeTransfer,
        int $idNavigation,
        ?int $idParentNavigationNode = null,
    ): void {
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
    public function getIdLocale(string $locale): int
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
        $navigationEntity = $this->findNavigationByIdNavigation(
            $navigationTreeTransfer->getNavigationOrFail()->getIdNavigationOrFail(),
        );

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
     * @param int $idNavigation
     *
     * @return \Orm\Zed\Navigation\Persistence\SpyNavigation|null
     */
    protected function findNavigationByIdNavigation(int $idNavigation): ?SpyNavigation
    {
        return (new SpyNavigationQuery())->findOneByIdNavigation($idNavigation);
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
     * @param array<string> $localizedSlugs
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

    /**
     * @param callable $callable
     * @param int $maxCount
     * @param bool $verbose
     *
     * @return void
     */
    public function repeatUnstableActions(callable $callable, int $maxCount = 10, bool $verbose = false): void
    {
        $count = 0;

        while ($count < $maxCount) {
            try {
                $callable();

                break;
            } catch (Exception $exception) {
                $count++;
                if ($verbose) {
                    echo "Try: {$count}: ";
                }
            }
        }
    }
}
