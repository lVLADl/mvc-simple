<?php


namespace App\Controllers;


class ExampleController extends Controller {
    public function index() {
        return render('index', [
            'name' => 'Fabien',
            'arr' => ['a', 'b', 'c']
        ]);
    }
}