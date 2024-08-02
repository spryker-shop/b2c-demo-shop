<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Pyz\Service\Nlp\NlpGenerator;

use Generated\Shared\Transfer\NlpResponseTransfer;

class NlpGenerator implements NlpGeneratorInterface
{


    /**
     *
     */
    public function __construct()
    {

    }

    /**
     * @param string $text
     * @param string|null $generatorPlugin
     */
    public function generateNlp(string $text)
    {
        $data = [
            "contents" => [
                [
                    "role" => "user",
                    "parts" => [
                        [
                            "text" => "\".$text.\" from this phrase extract the data in below format {product_type: , brand:,category: , sub_category: , attributes:list(key,value)} , attributes , subcategory, category should contain list of all synonyms"
                        ],
                    ]
                ]
            ],
            "generationConfig" => [
                "maxOutputTokens" => 8192,
                "temperature" => 1,
                "topP" => 0.95,
            ],

        ];

        $jsonData = json_encode($data);

        $projectId = "valued-bivouac-430416-b8";
        $locationId = "us-central1";
        $apiEndpoint = "us-central1-aiplatform.googleapis.com";
        $modelId = "gemini-1.5-flash-001";

        $accessToken = 'ya29.a0AXooCgsOstziZLOCRobYCqBnaAg_kfnPUggP04-ZTfHFEakM_a6rwxc2O7tqbTSoXmYRMap7bJLi1Eid_CQJufS0SNHXe5XopYfya2D40RPCrjLLzFBGPmGsYVgjT8MVeogs8NvekS9uuDF0taPuHrrnBiEStFoU8y3KHXrQeUIaCgYKAU4SARASFQHGX2Mi4tLV6AemGcYfU-Byal5-lg0178';

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => "https://{$apiEndpoint}/v1/projects/{$projectId}/locations/{$locationId}/publishers/google/models/{$modelId}:streamGenerateContent",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $jsonData,
            CURLOPT_HTTPHEADER => [
                "Authorization: Bearer $accessToken",
                "Content-Type: application/json"
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            $response =  "cURL Error #:" . $err;
        } else {
            $data = json_decode($response, true);
        $fullText = '';


        foreach ($data as $item) {
            if (isset($item['candidates'])) {
                foreach ($item['candidates'] as $candidate) {
                    if (isset($candidate['content']['parts'])) {
                        foreach ($candidate['content']['parts'] as $part) {
                            if (isset($part['text'])) {
                                $fullText .= $part['text'];
                            }
                        }
                    }
                }
            }
        }

        $jsonDat = $this->getData($fullText, '```json', '```');
        $response = json_decode($jsonDat,true);
        }
        return $response;
    }

    public function getData($string, $start, $end) {
        $startPos = strpos($string, $start);
        if ($startPos === false) {
            return false;
        }

        $startPos += strlen($start);

        $endPos = strpos($string, $end, $startPos);
        if ($endPos === false) {
            return false;
        }

        $length = $endPos - $startPos;

        return substr($string, $startPos, $length);
    }
}
