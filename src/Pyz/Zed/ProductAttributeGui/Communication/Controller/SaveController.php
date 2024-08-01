<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Pyz\Zed\ProductAttributeGui\Communication\Controller;

use Spryker\Zed\Kernel\Communication\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Spryker\Zed\ProductAttributeGui\Communication\Controller\SaveController as SpySaveController;

/**
 * @method \Spryker\Zed\ProductAttributeGui\Communication\ProductAttributeGuiCommunicationFactory getFactory()
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
        // $productData = $this->getRepository()
        foreach ($data as $key => $attribute) {
            if ($attribute[static::ATTRIBUTE_KEY] === static::CARBON_EMISSION_ATTRIBUTE) {
                $attribute[static::ATTRIBUTE_VALUE] = "50";
                $data[$key] = $attribute;
            }

            // if ($attribute[static::ATTRIBUTE_KEY] === static::ENERGY_EMISSION_ATTRIBUTE) {
            //     $attribute[static::ATTRIBUTE_VALUE] = "110";
            //     $data[$key] = $attribute;
            // }
        }

        $this->getFactory()
            ->getProductAttributeFacade()
            ->saveAbstractAttributes($idProductAbstract, $data);

        return $this->createJsonResponse(static::MESSAGE_PRODUCT_ABSTRACT_ATTRIBUTES_SAVED);
    }

    protected function getCarbonEmissionFromApi($productPrice, $currency = 'eur')
    {

        $data['emission_factor']['id'] = '4b703411-bd44-4d30-a069-dd59b1a61a0b';
        $data['parameters']['money'] = $productPrice;
        $data['parameters']['money_unit'] = $currency;
        $carbonEmission = $this->sendCurlRequest('https://beta4.api.climatiq.io/estimate', $data);
echo "<pre>";print_r($carbonEmission);die('WWW');
        return '{
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

    protected function sendCurlRequest($url, $data)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HEADER, 'Authorization: Bearer API_KEY');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);

        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        $contents = curl_exec($ch);
        curl_close($ch);
        return $contents;
    }
}
