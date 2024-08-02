<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Pyz\Service\Nlp\NlpGenerator;

use Exception;
use Generated\Shared\Transfer\NlpResponseTransfer;
use Google\Auth\Credentials\ServiceAccountCredentials;
use Google\Auth\Middleware\AuthTokenMiddleware;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;

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
        $serviceAccountFile = '/data/valued-bivouac-430416-b8-aa1869b60e91.json';

        $scopes = ['https://www.googleapis.com/auth/cloud-platform'];
        try{
                $credentials = new ServiceAccountCredentials($scopes, $serviceAccountFile);
        }catch(Exception $e){
            dd($e);
        }
        $accessToken = $credentials->fetchAuthToken()['access_token'];
        $data = [
            "contents" => [
                [
                    "role" => "user",
                    "parts" => [
                        [
                            "text" => '"'.$text.'" from this phrase extract the product information in below format {
                            "product_type": "extracted_value",
                            "attributes": [
                            {
                            "key": "extracted_value",
                            "value": "extracted_value"
                            },
                            {
                            "key": "extracted_value",
                            "value": "extracted_value",
                            "min": "extracted_value",
                            "max": "extracted_value"
                            }
                            ]
                            }
                            , min max are the values if attribute value is numeric. if no min or max intention is found then key can be omitted from result . value should contain only rounded numeric value , not the below , above  intents. attribute key can be one of from the list : ",torage_capacity,series,width,white_balance,weight,waterproof_up_to,waterproof,voice_recording,video_recording_modes,usb_version,usb_port,touchscreen,touch_technology,total_megapixels,thermal_design_power,themes,tcase,system_bus_rate,storage_media,stepping,sim_card_type,shape,sensor_type,self_timer,scenario_design_power,recording_time,rear_camera_resolution,rear_camera,protection_feature,product_type,processor_threads,processor_socket,processor_operating_models,processor_model,processor_frequency,processor_cores,processor_codename,processor_cache,processor_cache_type,processor_boost_frequency,photo_effects,pci_express_slots_version,pci_express_configurations,os_version,os_installed,optical_zoom,optical_sensor_size,mhl_version,memory_slots,megapixel,max_memory_card_size,internal_memory,light_exposure_modes,iso_sensitivity,internal_storage_capacity,internal_ram,intel_smart_cache,image_processor,headphone_connectivity,hdmi,hd_type,graphics_adapter,gps_satellite,full_hd,fsb_parity,front_camera_resolution,form_factor,focus_adjustment,focus,flash_type,flash_range_tele,flash_memory,fingerprint_reader,filter_size,field_of_view,face_detection,effective_megapixels,display_type,display_technology,display_diagonal,display,digital_zoom,cpu_configuration,control_type,compatible_memory_cards,combined_zoom,color,clock_mode,chassis_type,camera_type,camcorder_type,camcorder_media_type,bus_type,brand,bluetooth_version,battery_type,battery_life,backlight,auto_focus,audio_system,aspect_ratio,alarm_clock,4g_standards,4g,os_system,wi_fi,total_storage_capacity,bundled_product,packaging_unit,upcs,carbon_emission
                            "'
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
