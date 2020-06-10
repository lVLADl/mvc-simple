<?php

function path(...$components) {
    $final_path = '' ;
    foreach($components as $component) {
        $sep = ($component == $components[sizeof($components)-1]) ?'':DIRECTORY_SEPARATOR;
        $final_path .= $component . $sep;
    }

    return $final_path;
}
function config($name){ # -- config-name.parameter
    $buf = explode('.', $name);

    $config = $buf[0] . '.php';
    $component = $buf[1];


    return (include path(BASE_DIR, 'config', $config))[$component] ?? NULL;
}