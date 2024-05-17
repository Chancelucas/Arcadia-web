<?php

namespace Lib\config;

use Cloudinary\Api\Upload\UploadApi;

class CloudinaryManager
{
    public static function uploadImage($imagePath)
    {
        // Utilisation de la configuration Cloudinary via le singleton
        CloudinaryConfigSingleton::getInstance();

        // Upload de l'image
        $uploadResult = (new UploadApi())->upload($imagePath);
        return $uploadResult['secure_url'] ?? null;
    }

}
