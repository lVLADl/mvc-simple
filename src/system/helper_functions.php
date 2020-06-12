<?php

function __stop_caching() {
    header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
    header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
    header("Connection: close");
}
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


function get($url, $controller) {
    global $URL;
    $URL[$url] = new \App\System\URL\URLInstance($url, 'GET', $controller);
}
function post($url, $controller) {
    global $URL;
    $URL[$url] = new \App\System\URL\URLInstance($url, 'POST', $controller);
}
function put($url, $controller) {
    global $URL;
    $URL[$url] = new \App\System\URL\URLInstance($url, 'PUT', $controller);
}
function delete($url, $controller) {
    global $URL;
    $URL[$url] = new \App\System\URL\URLInstance($url, 'DELETE', $controller);
}


function page_404($msg) {
    throw new \Exception($msg);
    # TODO: Handle not found-section
};