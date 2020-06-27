<?php


namespace App\Controllers;

class ExampleController extends Controller {
    public function index() {
        $args = [];
        foreach($_GET as $name=>$value) {
            $args[$name] = $value;
        }
        return render('index', $args);
    }
}