<?php


namespace App\Controllers;


class AuthController {
    public function register() {
        return 'Hello from ' . __METHOD__ . '/' . __CLASS__;
    }
    public function login() {
        $email = @$_POST['email'];
        $password = @$_POST['password'];

        if(!$email or !$password) {
            $url = config('general.url') . '?'; # build absolute path to the index-page
            /* TODO: add path()- function to build absolute/relative paths */

            $errors = [];
            if(!$email) {
                $url .= 'error_login_email=' . urlencode('Email is required') . '&';
            }
            if(!$password) {
                $url .= 'error_login_password=' . urlencode('Password is required');
            }

            header("Location: $url");
            exit();
        }

        return 'Hello';
    }
}