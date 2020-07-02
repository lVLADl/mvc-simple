<?php


namespace App\Controllers;


use App\System\Request;

class ErrorController {
    public function serverError(Request $request) {
        return response()->error_page(500);
    }
}