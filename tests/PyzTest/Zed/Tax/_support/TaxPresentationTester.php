<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace PyzTest\Zed\Tax;

use Codeception\Actor;
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

    public function createTaxRate(string $taxRateName): void
    {
        $i = $this;

        $i->fillTaxRateForm($taxRateName);
        $i->click(TaxRateCreatePage::SELECTOR_SAVE);
    }

    protected function fillTaxRateForm(string $taxRateName): void
    {
        $i = $this;

        $i->amLoggedInUser();
        $i->amOnPage(TaxRateCreatePage::URL);

        $i->disableBrowserNativeValidation('form');

        $i->fillField(TaxRateCreatePage::SELECTOR_NAME, TaxRateCreatePage::$taxRateData[$taxRateName]['name']);
        $i->selectOption(TaxRateCreatePage::SELECTOR_COUNTRY, TaxRateCreatePage::$taxRateData[$taxRateName]['country']);
        $i->fillField(TaxRateCreatePage::SELECTOR_PERCENTAGE, TaxRateCreatePage::$taxRateData[$taxRateName]['percentage']);
    }

    public function createTaxRateWithoutSaving(string $taxRateName): void
    {
        $i = $this;
        $i->fillTaxRateForm($taxRateName);
    }

    public function searchForTaxRate(string $taxRateName): void
    {
        $i = $this;

        $i->fillField(TaxRateListPage::SELECTOR_SEARCH, TaxRateCreatePage::$taxRateData[$taxRateName]['name']);
    }

    public function deleteTaxRate(string $taxRateName): void
    {
        $i = $this;
        $i->amOnPage(TaxRateListPage::URL);

        $i->fillField(TaxRateListPage::SELECTOR_SEARCH, TaxRateCreatePage::$taxRateData[$taxRateName]['name']);
        $i->click(TaxRateListPage::SELECTOR_DELETE);
    }

    public function seeErrorMessages(): void
    {
        $i = $this;

        $i->see(TaxRateCreatePage::ERROR_MESSAGE_NAME_SHOULD_NOT_BE_BLANK);
        $i->see(TaxRateCreatePage::ERROR_MESSAGE_COUNTRY_SHOULD_NOT_BE_BLANK);
        $i->see(TaxRateCreatePage::ERROR_MESSAGE_PERCENTAGE_SHOULD_BE_VALID_RANGE);
    }

    public function createOneAndTheSameTaxRate(string $taxRateName): void
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

    public function editTaxRateWithValidData(string $taxRateName): void
    {
        $i = $this;

        $i->fillField(TaxRateCreatePage::SELECTOR_NAME, TaxRateCreatePage::$taxRateData[$taxRateName]['name']);
        $i->selectOption(TaxRateCreatePage::SELECTOR_COUNTRY, TaxRateCreatePage::$taxRateData[$taxRateName]['country']);
        $i->fillField(TaxRateCreatePage::SELECTOR_PERCENTAGE, TaxRateCreatePage::$taxRateData[$taxRateName]['percentage']);

        $i->click(TaxRateCreatePage::SELECTOR_SAVE);
    }

    public function deleteTaxRateFromEditForm(): void
    {
        $i = $this;

        $i->click(TaxRateCreatePage::SELECTOR_DELETE_FROM_EDIT);
    }

    public function removeTaxRateFromDatabase(string $taxRateName): void
    {
        $taxRateQuery = new SpyTaxRateQuery();
        $taxRateEntity = $taxRateQuery->findOneByName(TaxRateCreatePage::$taxRateData[$taxRateName]['name']);
        if (!$taxRateEntity) {
            return;
        }

        $taxRateEntity->delete();
    }
}
