<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function login() {
        return view('user.login');
    }

    public function register() {
        return view('user.register');
    }

    public function createUser(Request $request): \Illuminate\Http\RedirectResponse {
        $data = $request->all();
        $user = new User();

        $user->name     = htmlentities($data['name']);
        $user->email    = htmlentities($data['email']);
        $user->password = bcrypt($data['password']);
        $user->save();

        Auth::login($user);
        event(new Registered($user));
        return redirect()->route('index');
    }

    public function loginUser(Request $request) {
        $data = $request->all();
        if (Auth::attempt(['email' => $data['email'], 'password' => $data['password']])) {
            return redirect()->route('index');
        }

        return redirect()->route('user.login')->with('message', 'Password or email is wrong');
    }
}
