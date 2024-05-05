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

    public static function deleteImage($publicId)
    {
        // Implémentez la logique pour supprimer une image sur Cloudinary
    }

    public static function getImageUrl($publicId)
    {
        // Implémentez la logique pour récupérer l'URL d'une image sur Cloudinary
    }
}
