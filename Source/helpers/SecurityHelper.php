<?php

namespace Source\Helpers;

use Source\Helpers\InputType;

use DateTime;
use InvalidArgumentException;

class SecurityHelper
{
    public static function sanitize(InputType $type, $inputName, $source = INPUT_POST)
    {
        switch ($type) {
            case InputType::Int:
                return filter_input($source, $inputName, FILTER_SANITIZE_NUMBER_INT);

            case InputType::String:
                return htmlspecialchars(strip_tags($_POST[$inputName]), ENT_QUOTES, 'UTF-8');

            case InputType::Date:
                // Assuming the date format is 'Y-m-d', you may adjust according to your needs
                $date = $_POST[$inputName];
                $dateTime = DateTime::createFromFormat('Y-m-d', $date);
                return $dateTime ? $dateTime->format('Y-m-d') : null;

            default:
                throw new InvalidArgumentException("Unsupported type provided.");
        }
    }
}
