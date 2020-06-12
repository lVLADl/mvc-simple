<?php


namespace App\Controllers;


class ExampleController extends Controller {
    public function index() {
        global $twig;
        echo $twig->render('index.twig', ['name' => 'Fabien']);
    }
}