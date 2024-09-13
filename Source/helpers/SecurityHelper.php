<?php

namespace Source\Helpers;


// function securityHTML(string $string, int $flag = ENT_QUOTES | ENT_HTML5, string $character = 'UTF-8'): string
// {
//   return htmlspecialchars($string, $flag, $character);
// }

function securityHTML($input)
{
    return htmlspecialchars($input, ENT_QUOTES | ENT_HTML5, 'UTF-8');
}

function securityFilter($input)
{
    return filter_input(INPUT_POST, $input, FILTER_SANITIZE_NUMBER_INT);
}

function securityStripTags($input, $name)
{
    return strip_tags($_FILES[$input][$name]);
}