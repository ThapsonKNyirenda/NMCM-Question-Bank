<?php

return [
    'cache' => [

        'expiration_time' => \DateInterval::createFromDateString('6 hours'),

        /*
         * The cache key used to store all permissions.
         */
        'key' => 'maren_crm.permission.cache',

        'store' => 'default',
    ],
];
