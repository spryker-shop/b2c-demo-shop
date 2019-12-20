<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace PyzTest\Zed\ProductRelation;

use Codeception\Actor;
use Codeception\Scenario;

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
 * @method \Codeception\Lib\Friend haveFriend($name, $actorClass = null)
 *
 * @SuppressWarnings(PHPMD)
 */
class ProductRelationPresentationTester extends Actor
{
    use _generated\ProductRelationPresentationTesterActions;

    public const ELEMENT_TIMEOUT = 45;
    public const PRODUCT_RELATION_TYPE_SELECTOR = '//*[@id="product_relation_productRelationType"]';
    public const PRODUCT_TABLE_FILTER_LABEL_INPUT_SELECTOR = '//*[@id="product-table_filter"]/label/input';
    public const PRODUCT_TAB_SELECTOR = '//*[@id="form-product-relation"]/div/ul/li[2]/a';
    public const SUBMIT_RELATION_BUTTON_SELECTOR = '//*[@id="submit-relation"]';
    public const ACTIVATE_RELATION_BUTTON_SELECTOR = '//*[@id="activate-relation"]';

    /**
     * @var int
     */
    protected $numberOfRulesSelected = 0;

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
     * @param string $type
     *
     * @return $this
     */
    public function selectRelationType($type)
    {
        $this->waitForElement(static::PRODUCT_RELATION_TYPE_SELECTOR, static::ELEMENT_TIMEOUT);
        $this->selectOption(static::PRODUCT_RELATION_TYPE_SELECTOR, $type);

        return $this;
    }

    /**
     * @param string $name
     *
     * @return $this
     */
    public function filterProductsByName($name)
    {
        $this->waitForElement(static::PRODUCT_TABLE_FILTER_LABEL_INPUT_SELECTOR, static::ELEMENT_TIMEOUT);
        $this->fillField(static::PRODUCT_TABLE_FILTER_LABEL_INPUT_SELECTOR, $name);

        return $this;
    }

    /**
     * @param string $sku
     *
     * @return $this
     */
    public function selectProduct($sku)
    {
        $buttonElementId = sprintf('//*[@id="select-product-%s"]', $sku);

        $this->waitForElementNotVisible('//*[@id="product-table_processing"]', self::ELEMENT_TIMEOUT);
        $this->waitForElement($buttonElementId, self::ELEMENT_TIMEOUT);

        $this->click($buttonElementId);

        return $this;
    }

    /**
     * @return $this
     */
    public function switchToAssignProductsTab()
    {
        $this->waitForElement(static::PRODUCT_TAB_SELECTOR, static::ELEMENT_TIMEOUT);
        $this->click(static::PRODUCT_TAB_SELECTOR);

        return $this;
    }

    /**
     * @param string $ruleName
     * @param string $operator
     * @param string $value
     *
     * @return $this
     */
    public function selectProductRule($ruleName, $operator, $value)
    {
        $ruleSelectorBaseId = sprintf('[@id="builder_rule_%d"]', $this->numberOfRulesSelected);

        $selectProductRule = sprintf('//*%s/div[3]/select', $ruleSelectorBaseId);
        $this->waitForElement($selectProductRule, static::ELEMENT_TIMEOUT);
        $this->selectOption($selectProductRule, $ruleName);
        $selectProductOperator = sprintf('//*%s/div[4]/select', $ruleSelectorBaseId);
        $this->waitForElement($selectProductOperator, static::ELEMENT_TIMEOUT);
        $this->selectOption($selectProductOperator, $operator);
        $selectProductValue = sprintf('//*%s/div[5]/input', $ruleSelectorBaseId);
        $this->waitForElement($selectProductValue, static::ELEMENT_TIMEOUT);
        $this->fillField($selectProductValue, $value);

        $this->numberOfRulesSelected++;

        return $this;
    }

    /**
     * @return $this
     */
    public function clickSaveButton()
    {
        $this->waitForElement(static::SUBMIT_RELATION_BUTTON_SELECTOR, static::ELEMENT_TIMEOUT);
        $this->click(static::SUBMIT_RELATION_BUTTON_SELECTOR);

        return $this;
    }

    /**
     * @return $this
     */
    public function activateRelation()
    {
        $this->waitForElement(static::ACTIVATE_RELATION_BUTTON_SELECTOR, static::ELEMENT_TIMEOUT);
        $this->click(static::ACTIVATE_RELATION_BUTTON_SELECTOR);

        return $this;
    }
}
