<?php


namespace App\Controllers;


use App\Model\UserModel;

class AuthController {

    public function logout() {
        logout();
        redirect('');
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

            redirect('', $errors);
        }

        $user = UserModel::get($email);
        if($user) {
            $user->authorize($password);
            redirect();
        } else {
            $errors = [
                'error_login_user_not_found' => 'true'
            ];

            redirect('', $errors);
        }
    }
    public function register() {
        $name = @$_POST['name'] ?? null;

        $email = @$_POST['email'];
        $password = @$_POST['password'];

        if(!$email or !$password) {
            $errors = [];

            if(!$email) {
                $errors['error_register_email'] = 'Email is required';
            }
            if(!$password) {
                $errors['error_register_password'] = 'Password is required';
            }

            redirect('', $errors);
        }

        if(UserModel::all()->where('email', $email)->count()>0) {
            redirect('', [
                'error_register_email_exists' => 'Email already exists'
            ]);
        }

        $user = UserModel::register([
            'name' => $name,
            'email' => $email,
            'password' => $password
        ]);

        if($user) {
            $user->authorize($password);
            redirect('');
        }
    }
}