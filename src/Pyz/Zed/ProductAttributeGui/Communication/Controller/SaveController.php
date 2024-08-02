<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Pyz\Zed\ProductAttributeGui\Communication\Controller;

use Generated\Shared\Transfer\LocaleTransfer;
use Spryker\Zed\Kernel\Communication\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Spryker\Zed\ProductAttributeGui\Communication\Controller\SaveController as SpySaveController;

/**
 * @method \Pyz\Zed\ProductAttributeGui\Communication\ProductAttributeGuiCommunicationFactory getFactory()
 * @method \Pyz\Zed\ProductAttributeGui\ProductAttributeGuiConfig getConfig()
 */
class SaveController extends SpySaveController
{
    /**
     * @var string
     */
    public const ENERGY_EMISSION_ATTRIBUTE = 'energy_emission';

    /**
     * @var string
     */
    public const CARBON_EMISSION_ATTRIBUTE = 'carbon_emission';

    /**
     * @var string
     */
    public const ATTRIBUTE_KEY = 'key';


    /**
     * @var string
     */
    public const ATTRIBUTE_VALUE = 'value';

    /**
     * @var string
     */
    public const LOCALE_CODE = 'locale_code';

    /**
     * @var string
     */
    public const ID = 'id';

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse|array
     */
    public function productAbstractAction(Request $request)
    {
        if (!$this->validateCsrfToken($request)) {
            return $this->createJsonResponse(static::MESSAGE_INVALID_CSRF_TOKEN, false, Response::HTTP_FORBIDDEN);
        }

        $idProductAbstract = $this->castId($request->get(
            static::PARAM_ID_PRODUCT_ABSTRACT,
        ));

        $json = (string)$request->request->get(static::PARAM_JSON);
        $data = json_decode($json, true);
        $productData = $this->getFactory()->getProductFacade()->findProductAbstractById($idProductAbstract);
        $prices = $productData->getPrices();
        foreach ($prices as $price) {
            $productPrice = $price->getMoneyValue()->getGrossAmount();
            break;
        }
        $defaultLocale = $this->getFactory()->getConfig()->getDefaultLocaleCode();
        $token = $this->getFactory()->getConfig()->getCarbonEmissionToken();
        $carbonEmission = $this->getCarbonEmissionFromApi($token, $productPrice);
        $energyEmission = $this->getEnergyEmissionFromApi($token);
        
        $carbonFlag = 0;
        $energyFlag = 0;
        foreach ($data as $key => $attribute) {
            if ($attribute[static::ATTRIBUTE_KEY] === static::CARBON_EMISSION_ATTRIBUTE) {
                $attribute[static::ATTRIBUTE_VALUE] = $carbonEmission;
                $data[$key] = $attribute;
                $carbonFlag++;
            }

            if ($attribute[static::ATTRIBUTE_KEY] === static::ENERGY_EMISSION_ATTRIBUTE) {
                $attribute[static::ATTRIBUTE_VALUE] = $energyEmission;
                $data[$key] = $attribute;
                $energyFlag++;
            }
        }

        if($carbonFlag == 0) {
            $carbonAttributeId = $this->getAttributeIdByKey(static::CARBON_EMISSION_ATTRIBUTE);
            $locales = $this->getFactory()->getLocaleFacade()->getLocaleCollection();
            foreach ($locales as $locale => $value) {
                $carbonData = $this->prepareAttributeData($carbonAttributeId, static::CARBON_EMISSION_ATTRIBUTE, $carbonEmission, $locale);
                $data[count($data)] = $carbonData;
            }

            $carbonData = $this->prepareAttributeData($carbonAttributeId, static::CARBON_EMISSION_ATTRIBUTE, $carbonEmission, $defaultLocale);
            $data[count($data)] = $carbonData;
        }

        if($energyFlag == 0) {
            $energyAttributeId = $this->getAttributeIdByKey(static::ENERGY_EMISSION_ATTRIBUTE);
            $locales = $this->getFactory()->getLocaleFacade()->getLocaleCollection();
            foreach ($locales as $locale => $value) {
                $energyData = $this->prepareAttributeData($energyAttributeId, static::ENERGY_EMISSION_ATTRIBUTE, $energyEmission, $locale);
                $data[count($data)] = $energyData;
            }

            $energyData = $this->prepareAttributeData($energyAttributeId, static::ENERGY_EMISSION_ATTRIBUTE, $energyEmission, $defaultLocale);
            $data[count($data)] = $energyData;
        }

        $this->getFactory()
            ->getProductAttributeFacade()
            ->saveAbstractAttributes($idProductAbstract, $data);

        return $this->createJsonResponse(static::MESSAGE_PRODUCT_ABSTRACT_ATTRIBUTES_SAVED);
    }

    protected function prepareAttributeData($attributeId, $attributeKey, $attributeValue, $locale)
    {
        $attributeData[static::ATTRIBUTE_KEY] = $attributeKey;
        $attributeData[static::ATTRIBUTE_VALUE] = $attributeValue;
        $attributeData[static::LOCALE_CODE] = $locale;
        $attributeData[static::ID] = $attributeId;

        return $attributeData;
    }

    protected function getAttributeIdByKey($attributeKey)
    {
        $attribute = $this->getFactory()->getProductAttributeQueryContainer()->queryProductAttributeKeyByKeys([$attributeKey])->find();
        return $attribute[0]->getIdProductAttributeKey() ?? null;
    }

    protected function getCarbonEmissionFromApi($token, $productPrice, $currency = 'eur')
    {

        $data['emission_factor']['id'] = '4b703411-bd44-4d30-a069-dd59b1a61a0b';
        $data['parameters']['money'] = $productPrice;
        $data['parameters']['money_unit'] = $currency;
        if ($token) {
            $carbonEmission = $this->sendCurlRequest('https://beta4.api.climatiq.io/estimate', $data, $token);
        } else {
            $carbonEmission = '{
            "co2e": 29213,
            "co2e_unit": "kg",
            "co2e_calculation_method": "ar5",
            "co2e_calculation_origin": "source",
            "emission_factor": {
                "name": "Electrical machinery and apparatus (not elsewhere specified)",
                "activity_id": "electrical_equipment-type_electrical_machinery_apparatus_not_elsewhere_specified",
                "id": "4b703411-bd44-4d30-a069-dd59b1a61a0b",
                "access_type": "public",
                "source": "EXIOBASE",
                "source_dataset": "EXIOBASE 3",
                "year": 2019,
                "region": "AT",
                "category": "Electrical Equipment",
                "source_lca_activity": "unknown",
                "data_quality_flags": []
            },
            "constituent_gases": {
                "co2e_total": 29213,
                "co2e_other": null,
                "co2": null,
                "ch4": null,
                "n2o": null
            },
            "activity_data": {
                "activity_value": 100011,
                "activity_unit": "eur"
            },
            "audit_trail": "selector"
            }';
        }

        $carbonEmissionData = json_decode($carbonEmission, true);
        return $carbonEmissionData['co2e'];
    }


    protected function getEnergyEmissionFromApi($token, $energyAmount = 100, $energyUnit = 'kWh')
    {

        $data['emission_factor']['activity_id'] = 'electricity-supply_grid-source_supplier_mix';
        $data['emission_factor']['region'] = 'IN';
        $data['emission_factor']['data_version'] = '5.5';
        $data['parameters']['energy'] = $energyAmount;
        $data['parameters']['energy_unit'] = $energyUnit;
        if ($token) {
            $energyEmission = $this->sendCurlRequest('https://beta4.api.climatiq.io/estimate', $data, $token);
        } else {
            $energyEmission = '{
            "co2e": 71.32,
            "co2e_unit": "kg",
            "co2e_calculation_method": "ar4",
            "co2e_calculation_origin": "source",
            "emission_factor": {
                "name": "Electricity supplied from grid",
                "activity_id": "electricity-supply_grid-source_supplier_mix",
                "id": "8eefd087-009f-4418-a989-de7103cd3194",
                "access_type": "public",
                "source": "CT",
                "source_dataset": "Climate Transparency Report",
                "year": 2021,
                "region": "IN",
                "category": "Electricity",
                "source_lca_activity": "electricity_generation",
                "data_quality_flags": [
                "partial_factor"
                ]
            },
            "constituent_gases": {
                "co2e_total": 71.32,
                "co2e_other": null,
                "co2": 71.32,
                "ch4": null,
                "n2o": null
            },
            "activity_data": {
                "activity_value": 100,
                "activity_unit": "kWh"
            },
            "audit_trail": "selector"
            }';
        }
        $energyEmissionData = json_decode($energyEmission, true);
        return $energyEmissionData['co2e'];

    }

    protected function sendCurlRequest($url, $data, $token)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization: Bearer '.$token]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        $contents = curl_exec($ch);
        curl_close($ch);
        return $contents;
    }
}
