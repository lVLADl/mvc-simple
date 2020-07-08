<?php


namespace App\Controllers;


use App\Model\UserModel;
use App\System\Request;

class AuthController {

    public function logout(Request $request) {
        logout();
        response()->redirect('');
    }

    public function login(Request $request) {
        $email = $request->post('email');
        $password = $request->post('password');;

        if(!$email or !$password) {
            $errors = [];

            if(!$email) {
                $errors['error_login_email'] = 'Email is required';
            }
            if(!$password) {
                $errors['error_login_password'] = 'Password is required';
            }

            response()->redirect('', $errors);
        }

        $user = UserModel::get($email);
        if($user) {
            $user->authorize($password);
            response()->redirect('');
        } else {
            $errors = [
                'error_login_user_not_found' => 'true'
            ];

            response()->redirect('', $errors);
        }
    }
    public function register(Request $request) {
        $name = $request->post('name', null);

        $email = $request->post('email');;
        $password = $request->post('password');

        if(!$email or !$password) {
            $errors = [];

            if(!$email) {
                $errors['error_register_email'] = 'Email is required';
            }
            if(!$password) {
                $errors['error_register_password'] = 'Password is required';
            }

            response()->redirect('', $errors);
        }

        /* TODO: replace with the unique-constraint */
        if(UserModel::all()->where('email', $email)->count()>0) {
            response()->redirect('', [
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
            response()->redirect('');
        }
    }
}