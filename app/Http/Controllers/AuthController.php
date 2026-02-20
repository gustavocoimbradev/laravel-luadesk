<?php

namespace App\Http\Controllers;

use App\Http\Requests\{StoreAuthRequest};
use App\Services\AuthService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AuthController extends Controller
{ 

    public function __construct(protected AuthService $service) {}

    public function create() {
        return Inertia::render('Auth/Create');
    }

    public function store(StoreAuthRequest $request) {
        if ($this->service->authenticate($request->validated())) {
            $request->session()->regenerate();
            return redirect()->intended(route('tickets.index'));
        } 
        return back()->withErrors([
            'message' => 'Invalid credentials'
        ]);
    }

    public function destroy(Request $request) {
        $this->service->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return to_route('auth.create');
    }
    
}
