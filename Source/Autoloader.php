<?php


namespace Source;

class Autoloader
{
    static function register()
    {
        spl_autoload_register([__CLASS__, 'autoload']);
    }

    static function autoload($class)
    {
        $class = str_replace(__NAMESPACE__ . '\\', '', $class);
        $class = str_replace('\\', DIRECTORY_SEPARATOR, $class);

        $contents = scandir(ROOT);

        foreach ($contents as $content) {
            $file = ROOT . DIRECTORY_SEPARATOR . $content . DIRECTORY_SEPARATOR . $class . '.php';
            if (file_exists($file)) {
                require_once $file;
                return; 
            }
        }
        echo "Le fichier de classe pour $class n'a pas été trouvé dans les dossiers racines spécifiés.";
    }
}

