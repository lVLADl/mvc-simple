<?php
namespace App\System;
use App\System\Exceptions\URLNotFound;

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
                try {
                    $result = $url_instance->call_method(new Request());
                } catch(\Exception $exception) {
                    if(config('general.debug')) {
                        /* TODO: add special page for displaying exceptions*/
                        $result = $exception->__toString();
                    } else {
                        $result = page_404('Internal server error');
                    }
                }

                print_r(@$result);
            } else {
                print page_404($method . ' method is not supported');
            }
        } else {
            print page_404('Page not found');
        }
    }
}