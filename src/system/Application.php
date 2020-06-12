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
            echo ($url_instance->call_method());
        } else {
            throw new \Exception('Page not found');
            # TODO: Handle not found-section
        }
    }
}