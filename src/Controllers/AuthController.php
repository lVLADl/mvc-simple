<?php


namespace App\Controllers;


use App\Model\UserModel;

class AuthController {
    public function register() {
        return 'Hello from ' . __METHOD__ . '/' . __CLASS__;
    }
    public function logout() {
        logout();
        redirect();
    }

    public function login() {
        $email = @$_POST['email'];
        $password = @$_POST['password'];

        if(!$email or !$password) {
            $errors = [];

            if(!$email) {
                $errors['error_login_email'] = 'Email is required';
            }
            if(!$password) {
                $errors['error_login_password'] = 'Password is required';
            }

            redirect($errors);
        }

        $user = UserModel::get($email);
        if($user) {
            $user->authorize($password);
            redirect();
        } else {
            $errors = [
                'error_login_user_not_found' => 'true'
            ];

            redirect($errors);
        }
    }
}