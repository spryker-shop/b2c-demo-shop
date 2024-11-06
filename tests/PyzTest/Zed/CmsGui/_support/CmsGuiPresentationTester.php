<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace PyzTest\Zed\CmsGui;

use Codeception\Actor;
use Faker\Factory;

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
 * @SuppressWarnings(\PyzTest\Zed\CmsGui\PHPMD)
 */
class CmsGuiPresentationTester extends Actor
{
    use _generated\CmsGuiPresentationTesterActions;

    /**
     * @var array|null
     */
    protected $localizedFakeData;

    /**
     * @param string $date
     *
     * @return $this
     */
    public function setValidFrom($date)
    {
        $date = $this->adaptDateInputForBrowser($date);
        $this->fillField('//*[@id="cms_page_validFrom"]', $date);

        return $this;
    }

    /**
     * @return $this
     */
    public function setIsSearchable()
    {
        $this->checkOption('//*[@id="cms_page_isSearchable"]');

        return $this;
    }

    /**
     * @param string $date
     *
     * @return $this
     */
    public function setValidTo($date)
    {
        $date = $this->adaptDateInputForBrowser($date);
        $this->fillField('//*[@id="cms_page_validTo"]', $date);

        return $this;
    }

    /**
     * @param int $formIndex
     * @param string $name
     * @param string $url
     *
     * @return $this
     */
    public function fillLocalizedUrlForm($formIndex, $name, $url)
    {
        $nameFieldIdentifier = sprintf('//*[@id="cms_page_pageAttributes_%s_name"]', $formIndex);
        $this->waitForElementVisible($nameFieldIdentifier);
        $this->fillField($nameFieldIdentifier, $name);
        $urlFieldIdentifier = sprintf('//*[@id="cms_page_pageAttributes_%s_url"]', $formIndex);
        $this->waitForElementVisible($urlFieldIdentifier);
        $this->fillField($urlFieldIdentifier, $url);

        return $this;
    }

    /**
     * @param int $placeHolderIndex
     * @param int $localeIndex
     * @param string $contents
     *
     * @return void
     */
    public function fillPlaceholderContents($placeHolderIndex, $localeIndex, $contents): void
    {
        $translationElementId = 'cms_glossary_glossaryAttributes_' . $placeHolderIndex . '_translations_' . $localeIndex . '_translation';

        $this->executeJS("$('#$translationElementId').text('$contents');");
    }

    /**
     * @return $this
     */
    public function expandLocalizedUrlPane()
    {
        $this->click('//*[@id="tab-content-general"]/div/div[7]/div[1]/a');

        return $this;
    }

    /**
     * @return $this
     */
    public function clickSubmit()
    {
        $this->click('//*[@id="submit-cms"]');

        return $this;
    }

    /**
     * @return $this
     */
    public function clickPublishButton()
    {
        $this->click('//*[@id="page-wrapper"]/div[2]/div[2]/div/form/button');

        return $this;
    }

    /**
     * @return $this
     */
    public function includeJquery()
    {
        $this->executeJS(
            '
             var jq = document.createElement("script");
             jq.src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js";
             document.getElementsByTagName("head")[0].appendChild(jq);
            ',
        );

        $this->wait(3);

        return $this;
    }

    /**
     * @return int
     */
    public function grabCmsPageId(): int
    {
        return $this->grabFromCurrentUrl('/id-cms-page=(\d+)/');
    }

    /**
     * @return array
     */
    protected function getLocalizedFakeData(): array
    {
        if (!$this->localizedFakeData) {
            $this->localizedFakeData = [];
            $locales = ['de' => 'de_DE', 'en' => 'en_US'];
            foreach ($locales as $country => $locale) {
                $faker = Factory::create($locale);
                $this->localizedFakeData[$country] = [
                    'name' => $faker->name,
                    'url' => sprintf('/%s/%s', $country, $faker->slug),
                ];
            }
        }

        return $this->localizedFakeData;
    }

    /**
     * @param string $locale
     *
     * @return string
     */
    public function getLocalizedName(string $locale): string
    {
        $localizedFakeData = $this->getLocalizedFakeData();

        return $localizedFakeData[$locale]['name'];
    }

    /**
     * @param string $locale
     *
     * @return string
     */
    public function getLocalizedUrl(string $locale): string
    {
        $localizedFakeData = $this->getLocalizedFakeData();

        return $localizedFakeData[$locale]['url'];
    }
}
