<?php

if (!function_exists('dump')) {
    function dump() {
        echo '<pre>';
        var_dump(...func_get_args());
        echo '</pre>';
    }
}

if (!function_exists('dd')) {
    function dd() {
        dump(...func_get_args());
        die;
    }
}

if (!function_exists('toJson')) {
    function toJson(array $array) {
        return json_decode(json_encode($array));
    }
}
