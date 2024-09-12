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