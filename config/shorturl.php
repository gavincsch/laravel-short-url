<?php

return [
    /*
     | Number of items per page.
     */
    'items_per_page' => 10,

    'url_prefix' => env('SHORT_URL_PATH', 'short-url'),

    'enable_custom_expired_handle' => false,
    'expired_redirect'  => null,

    /*
     | A list of non allowed keywords in url.
     */
    'blacklist' => [],
];
