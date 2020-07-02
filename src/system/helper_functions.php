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


# -- Settings
function config($name) { # -- config-name.parameter
    $buf = explode('.', $name);

    $config = $buf[0] . '.php';
    $component = $buf[1];


    return (include path(BASE_DIR, 'config', $config))[$component] ?? NULL;
}
function env($key, $default='') {
    return $_ENV[$key] ?? $default;
}

# -- URL-helpers
function get($url, $controller) {
    global $URL;
    return $URL[$url] = new \App\System\URL\URLInstance($url, 'GET', $controller);
}
function post($url, $controller) {
    global $URL;
    return $URL[$url] = new \App\System\URL\URLInstance($url, 'POST', $controller);
}
function put($url, $controller) {
    global $URL;
    return $URL[$url] = new \App\System\URL\URLInstance($url, 'PUT', $controller);
}
function delete($url, $controller) {
    global $URL;
    return $URL[$url] = new \App\System\URL\URLInstance($url, 'DELETE', $controller);
}


function response(): \App\System\Response {
    return new \App\System\Response();
}


/* Session */
function session_add($key, $value) {
    $_SESSION[$key] = $value;
}
function session_remove($key) {
    unset($_SESSION[$key]);
}
function session_get($key) {
    return $_SESSION[$key];
}


# -- auth
function is_authenticated(): bool {
    return @session_get('authorized') ?? false;
}

function user(): \App\Model\UserModel {
    return \App\Model\UserModel::get(session_get('email'));
}

function logout() {
    session_remove('authorized');
    session_remove('email');
}


/* builds url by route's- name; if not found, returns url to the homepage */
function buildPathByRoute(string $routeName) {
    global $URL;
    foreach($URL as $k=>$v) {
        if($routeName == @$v->getName()) {
            return config('general.url') . $k;
        }
    }

    throw new \App\System\Exceptions\URLNotFound();
}