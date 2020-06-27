<?php


namespace App\Controllers;

class ExampleController extends Controller {
    public function index() {
        $args = [];
        foreach($_GET as $name=>$value) {
            $args[$name] = $value;
        }

        $authenticated = $args['authenticated'] = is_authenticated();
        if($authenticated) {
            $args['user'] = user();
        }

        return render('index', $args);
    }
}