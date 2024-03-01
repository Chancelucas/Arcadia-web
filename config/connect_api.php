<?php

require_once __DIR__ . '../../vendor/autoload.php';

use Cloudinary\Configuration\Configuration;

Configuration::instance([
    'cloud' => [
        'cloud_name' => 'dnelvhydy',
        'api_key' => '238216653265659',
        'api_secret' => 'm-0rKwa9mvR1GstXTxvUqs25NPw',
    ],
    'url' => [
        'secure' => true,
        'cloudinary_url' => 'cloudinary://238216653265659:m-0rKwa9mvR1GstXTxvUqs25NPw@dnelvhydy'
    ]
]);
