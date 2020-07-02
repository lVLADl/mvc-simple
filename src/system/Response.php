<?php


namespace App\System;


class Response {
    public function json(array $array) {
        return json_encode($array);
    }
    public function render(string $template_name, array $args=[]) {
        global $twig;

        # TODO: Add middlewares
        $args['app_name'] = (string) config('general.app-name');
        return $twig->render($template_name . '.twig', $args);
    }

    public function redirect($path, $get_params=[]) {
        $url = config('general.url'); # build absolute path to the index-page
        if(!str_ends_with($url, '/') && !(str_starts_with($path, '/'))) {
            $url .= '/' . $path;
        } else {
            $url .= $path;
        }

        if(sizeof($get_params) > 0) {
            $url .= '?';
        }

        foreach($get_params as $key => $value) {
            $url .= "$key=" . urlencode($value) . ((array_key_last($get_params) == $key)?'':'&');
        }

        header("Location: $url");
        exit();
    }

    public function error_page(int $error_code, string $head='') {
        if(!$head) {
            switch($error_code) {
                case 404:
                    $head='Page not found';
                    break;
                case 500:
                    $head='Internal server error';
                    break;

                default:
                    $head = 'Unknown error has occurred';
                    break;
            }
        }

        return $this->render('error', ['error_header' => $head]);
    }
}