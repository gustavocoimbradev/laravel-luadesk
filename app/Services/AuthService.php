<?php 

namespace App\Services;

use Illuminate\Support\Facades\Auth;

class AuthService {

    public function authenticate(array $credentials): bool {
        return Auth::attempt($credentials);
    }

    public function logout(): void {
        Auth::logout();
    }

}