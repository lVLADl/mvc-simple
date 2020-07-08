<?php


namespace App\Controllers;

use App\System\Request;

class ExampleController extends Controller {
    public function index(Request $request) {
        $args = $request->get();

        // TODO: add these kind of functions to the templates (make new layer)
        // TODO: or make middlewares which will do it
        $authenticated = $args['authenticated'] = is_authenticated();
        if($authenticated) {
            $args['user'] = user();
        }

        return response()->render('index', $args);
    }

}