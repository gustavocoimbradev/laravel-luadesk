<?php

namespace App\Http\Controllers;

use App\Http\Requests\{StoreAuthRequest};
use App\Services\AuthService;
use Illuminate\Http\Client\Request;
use Inertia\Inertia;

class AuthController extends Controller
{ 

    public function __construct(protected AuthService $service) {}

    public function index() {
        return Inertia::render('Auth/Index');
    }

    public function store(StoreAuthRequest $request) {
        if ($this->service->authenticate($request->validated())) {
            $request->session()->regenerate();
            return redirect()->intended(route('tickets.index'));
        } 
        return to_route('auth.index')->withError('The provided credentials do not match our records.');
    }

    public function destroy(Request $request) {
        $this->service->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return to_route('auth.index');
    }
    
}
