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

        } else {
            throw new \Exception('Page not found');
            # TODO: Handle not found-section
        }
    }
}