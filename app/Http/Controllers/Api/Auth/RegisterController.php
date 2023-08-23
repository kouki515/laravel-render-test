<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;

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
