<?php

namespace Lib\config;

require __DIR__ . '/../vendor/autoload.php';

use Cloudinary\Configuration\Configuration;

class CloudinaryConfigSingleton
{
    private static $instance;
    private static $configured = false;

    private function __construct()
    {
        if (!self::$configured) {
            // Configuration Cloudinary
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

            self::$configured = true;
        }
    }

    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }
}
