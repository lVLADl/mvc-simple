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

        if(isset($URL[$_SERVER['REQUEST_URI']])) {
            $url_instance = $URL[$_SERVER['REQUEST_URI']];
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

                echo $result;
            } else {
                page_404($method . ' method is not supported');
            }
        } else {
            page_404('Page not found');
        }
    }
}