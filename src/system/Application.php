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
            /*
             *
             * TODO:
             * Middleware-section
             *
             */
            # --
            $result = $url_instance->call_method();


            echo ($result);
        } else {
            # throw new \Exception('Page not found');
            # TODO: Handle not found-section
        }
    }
}