<?php

$stores = [];

if (getenv('SPRYKER_ACTIVE_STORES')) {
    $activeStores = array_map('trim', explode(',', getenv('SPRYKER_ACTIVE_STORES')));

    $templates = [];
    $templates['default'] = [
        // different contexts
        'contexts' => [
            // shared settings for all contexts
            '*' => [
                'timezone' => 'Europe/Berlin',
                'dateFormat' => [
                    // short date (01.02.12)
                    'short' => 'd/m/Y',
                    // medium Date (01. Feb 2012)
                    'medium' => 'd. M Y',
                    // date formatted as described in RFC 2822
                    'rfc' => 'r',
                    'datetime' => 'Y-m-d H:i:s',
                ],
            ],
            // settings for contexts (overwrite shared)
            'yves' => [],
            'zed' => [
                'dateFormat' => [
                    // short date (2012-12-28)
                    'short' => 'Y-m-d',
                ],
            ],
        ],
        'locales' => [
            // first entry is default
            'en' => 'en_US',
            'de' => 'de_DE',
        ],
        // first entry is default
        'countries' => ['DE', 'AT', 'NO', 'CH', 'ES', 'GB'],
        // internal and shop
        'currencyIsoCode' => 'EUR',
        'currencyIsoCodes' => ['EUR', 'CHF'],
        'queuePools' => [
            'synchronizationPool' => [],
        ],
        'storesWithSharedPersistence' => [],
    ];

    $templates['US'] = [
        // different contexts
        'contexts' => [
            // shared settings for all contexts
            '*' => [
                'timezone' => 'America/Los_Angeles',
                'dateFormat' => [
                    // short date (11.14.12)
                    'short' => 'm/d/Y',
                    // medium Date (Feb 01. 2012)
                    'medium' => 'M d. Y',
                    // date formatted as described in RFC 2822
                    'rfc' => 'r',
                    'datetime' => 'Y-m-d H:i:s',
                ],
            ],
            // settings for contexts (overwrite shared)
            'yves' => [],
            'zed' => [
                'dateFormat' => [
                    // short date (12-28-2012)
                    'short' => 'm-d-Y',
                ],
            ],
        ],
        'locales' => [
            // first entry is default
            'en' => 'en_US',
        ],
        // first entry is default
        'countries' => ['US'],
        // internal and shop
        'currencyIsoCode' => 'USD',
        'currencyIsoCodes' => ['USD'],
    ] + $templates['default'];

    foreach ($activeStores as $store) {
        $stores[$store] = $templates[$store] ?? $templates['default'];
        $stores[$store]['storesWithSharedPersistence'] = array_diff($activeStores, [$store]);
        $stores[$store]['queuePools']['synchronizationPool'] = array_map(static function ($store) {
            return $store . '-connection';
        }, $activeStores);
    }

    return $stores;
}

$stores['DE'] = [
    // different contexts
    'contexts' => [
        // shared settings for all contexts
        '*' => [
            'timezone' => 'Europe/Berlin',
            'dateFormat' => [
                // short date (01.02.12)
                'short' => 'd/m/Y',
                // medium Date (01. Feb 2012)
                'medium' => 'd. M Y',
                // date formatted as described in RFC 2822
                'rfc' => 'r',
                'datetime' => 'Y-m-d H:i:s',
            ],
        ],
        // settings for contexts (overwrite shared)
        'yves' => [],
        'zed' => [
            'dateFormat' => [
                // short date (2012-12-28)
                'short' => 'Y-m-d',
            ],
        ],
    ],
    'locales' => [
        // first entry is default
        'en' => 'en_US',
        'de' => 'de_DE',
    ],
    // first entry is default
    'countries' => ['DE', 'AT', 'NO', 'CH', 'ES', 'GB'],
    // internal and shop
    'currencyIsoCode' => 'EUR',
    'currencyIsoCodes' => ['EUR', 'CHF'],
    'queuePools' => [
        'synchronizationPool' => [
            'AT-connection',
            'DE-connection',
        ],
    ],
    'storesWithSharedPersistence' => ['AT'],
];

$stores['AT'] = [
        'storesWithSharedPersistence' => ['DE'],
    ] + $stores['DE'];

$stores['US'] = [
    // different contexts
    'contexts' => [
        // shared settings for all contexts
        '*' => [
            'timezone' => 'America/Los_Angeles',
            'dateFormat' => [
                // short date (11.14.12)
                'short' => 'm/d/Y',
                // medium Date (Feb 01. 2012)
                'medium' => 'M d. Y',
                // date formatted as described in RFC 2822
                'rfc' => 'r',
                'datetime' => 'Y-m-d H:i:s',
            ],
        ],
        // settings for contexts (overwrite shared)
        'yves' => [],
        'zed' => [
            'dateFormat' => [
                // short date (12-28-2012)
                'short' => 'm-d-Y',
            ],
        ],
    ],
    'locales' => [
        // first entry is default
        'en' => 'en_US',
    ],
    // first entry is default
    'countries' => ['US'],
    // internal and shop
    'currencyIsoCode' => 'USD',
    'currencyIsoCodes' => ['USD'],
    'queuePools' => [
        'synchronizationPool' => [
            'US-connection',
        ],
    ],
    'storesWithSharedPersistence' => [],
];

return $stores;
