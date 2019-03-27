<?php

function dump() {
    echo '<pre>';
    var_dump(...func_get_args());
    echo '</pre>';
}

function dd() {
    dump(...func_get_args());
    die;
}

function toJson(array $array) {
    return json_decode(json_encode($array));
}
