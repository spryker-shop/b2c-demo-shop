<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace PyzTest\Zed\Tax;

use Codeception\Actor;
use Codeception\Scenario;
use Orm\Zed\Tax\Persistence\SpyTaxRateQuery;
use PyzTest\Zed\Tax\PageObject\TaxRateCreatePage;
use PyzTest\Zed\Tax\PageObject\TaxRateListPage;

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
 * @SuppressWarnings(\PyzTest\Zed\Tax\PHPMD)
 */
class TaxPresentationTester extends Actor
{
    use _generated\TaxPresentationTesterActions;

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
     * @param string $taxRateName
     *
     * @return void
     */
    public function createTaxRate($taxRateName): void
    {
        $i = $this;

        $i->fillTaxRateForm($taxRateName);
        $i->click(TaxRateCreatePage::SELECTOR_SAVE);
    }

    /**
     * @param string $taxRateName
     *
     * @return void
     */
    protected function fillTaxRateForm($taxRateName): void
    {
        $i = $this;

        $i->amLoggedInUser();
        $i->amOnPage(TaxRateCreatePage::URL);

        $i->disableBrowserNativeValidation('form');

        $i->fillField(TaxRateCreatePage::SELECTOR_NAME, TaxRateCreatePage::$taxRateData[$taxRateName]['name']);
        $i->selectOption(TaxRateCreatePage::SELECTOR_COUNTRY, TaxRateCreatePage::$taxRateData[$taxRateName]['country']);
        $i->fillField(TaxRateCreatePage::SELECTOR_PERCENTAGE, TaxRateCreatePage::$taxRateData[$taxRateName]['percentage']);
    }

    /**
     * @param string $taxRateName
     *
     * @return void
     */
    public function createTaxRateWithoutSaving($taxRateName): void
    {
        $i = $this;
        $i->fillTaxRateForm($taxRateName);
    }

    /**
     * @param string $taxRateName
     *
     * @return void
     */
    public function searchForTaxRate($taxRateName): void
    {
        $i = $this;

        $i->fillField(TaxRateListPage::SELECTOR_SEARCH, TaxRateCreatePage::$taxRateData[$taxRateName]['name']);
    }

    /**
     * @param string $taxRateName
     *
     * @return void
     */
    public function deleteTaxRate($taxRateName): void
    {
        $i = $this;
        $i->amOnPage(TaxRateListPage::URL);

        $i->fillField(TaxRateListPage::SELECTOR_SEARCH, TaxRateCreatePage::$taxRateData[$taxRateName]['name']);
        $i->click(TaxRateListPage::SELECTOR_DELETE);
    }

    /**
     * @return void
     */
    public function seeErrorMessages(): void
    {
        $i = $this;

        $i->see(TaxRateCreatePage::ERROR_MESSAGE_NAME_SHOULD_NOT_BE_BLANK);
        $i->see(TaxRateCreatePage::ERROR_MESSAGE_COUNTRY_SHOULD_NOT_BE_BLANK);
        $i->see(TaxRateCreatePage::ERROR_MESSAGE_PERCENTAGE_SHOULD_BE_VALID_RANGE);
    }

    /**
     * @param string $taxRateName
     *
     * @return void
     */
    public function createOneAndTheSameTaxRate($taxRateName): void
    {
        $i = $this;

        $i->amLoggedInUser();
        $i->amOnPage(TaxRateCreatePage::URL);

        $i->wait(4);

        $i->fillField(TaxRateCreatePage::SELECTOR_NAME, TaxRateCreatePage::$taxRateData[$taxRateName]['name']);
        $i->selectOption(TaxRateCreatePage::SELECTOR_COUNTRY, TaxRateCreatePage::$taxRateData[$taxRateName]['country']);
        $i->fillField(TaxRateCreatePage::SELECTOR_PERCENTAGE, TaxRateCreatePage::$taxRateData[$taxRateName]['percentage']);

        $i->click(TaxRateCreatePage::SELECTOR_SAVE);

        $i->amOnPage(TaxRateCreatePage::URL);

        $i->wait(2);

        $i->fillField(TaxRateCreatePage::SELECTOR_NAME, TaxRateCreatePage::$taxRateData[$taxRateName]['name']);
        $i->selectOption(TaxRateCreatePage::SELECTOR_COUNTRY, TaxRateCreatePage::$taxRateData[$taxRateName]['country']);
        $i->fillField(TaxRateCreatePage::SELECTOR_PERCENTAGE, TaxRateCreatePage::$taxRateData[$taxRateName]['percentage']);

        $i->click(TaxRateCreatePage::SELECTOR_SAVE);
    }

    /**
     * @param string $taxRateName
     *
     * @return void
     */
    public function editTaxRateWithValidData($taxRateName): void
    {
        $i = $this;

        $i->fillField(TaxRateCreatePage::SELECTOR_NAME, TaxRateCreatePage::$taxRateData[$taxRateName]['name']);
        $i->selectOption(TaxRateCreatePage::SELECTOR_COUNTRY, TaxRateCreatePage::$taxRateData[$taxRateName]['country']);
        $i->fillField(TaxRateCreatePage::SELECTOR_PERCENTAGE, TaxRateCreatePage::$taxRateData[$taxRateName]['percentage']);

        $i->click(TaxRateCreatePage::SELECTOR_SAVE);
    }

    /**
     * @return void
     */
    public function deleteTaxRateFromEditForm(): void
    {
        $i = $this;

        $i->click(TaxRateCreatePage::SELECTOR_DELETE_FROM_EDIT);
    }

    /**
     * @param string $taxRateName
     *
     * @return void
     */
    public function removeTaxRateFromDatabase($taxRateName): void
    {
        $taxRateQuery = new SpyTaxRateQuery();
        $taxRateEntity = $taxRateQuery->findOneByName(TaxRateCreatePage::$taxRateData[$taxRateName]['name']);
        if ($taxRateEntity) {
            $taxRateEntity->delete();
        }
    }
}
