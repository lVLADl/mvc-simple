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
function config($name) { # -- config-name.parameter
    $buf = explode('.', $name);

    $config = $buf[0] . '.php';
    $component = $buf[1];


    return (include path(BASE_DIR, 'config', $config))[$component] ?? NULL;
}
function env($key, $default='') {
    return $_ENV[$key] ?? $default;
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

function render(string $template_name, array $args=[]) {
    global $twig;

    # TODO: Add middlewares
    $args['app_name'] = (string) config('general.app-name');
    return $twig->render($template_name . '.twig', $args);
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

function redirect($path, $get_params=[]) {
    $url = config('general.url') . $path; # build absolute path to the index-page
    if(sizeof($get_params) > 0) {
        $url .= '?';
    }

    foreach($get_params as $key => $value) {
        $url .= "$key=" . urlencode($value) . ((array_key_last($get_params) == $key)?'':'&');
    }

    header("Location: $url");
    exit();
}