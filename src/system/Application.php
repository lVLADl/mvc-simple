<?php
namespace App\System;
class Application {
    public function __construct() { }
    public function run() {
        global $URL;
        /*
         * URL- section
         *
         */

        $url_ = explode('?', $_SERVER['REQUEST_URI'])[0]; // Handles GET-parameters
        if(isset($URL[$url_])) {
            $url_instance = $URL[$url_];
            $method = $_SERVER['REQUEST_METHOD'];

            if($url_instance->getMethod() == $method) {
                /*
                 *
                 * TODO:
                 * Middleware-section
                 *
                 */
                # --
                $result = $url_instance->call_method();

                print_r($result);
            } else {
                page_404($method . ' method is not supported');
            }
        } else {
            page_404('Page not found');
        }
    }
}