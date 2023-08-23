<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    use RegistersUsers;

    public function register()
    {
        $this->validator(request()->all())->validate();
        event(new Registered($user = $this->create(request()->all())));
        $this->guard()->login($user);
        return ['success' => true, 'user' => $user];
    }

    protected function create(array $data)
    {
        return User::create([
            'name'  => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
}
