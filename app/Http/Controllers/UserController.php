<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

class UserController extends Controller
{

    public function __construct(protected UserService $service) {}
    
    public function index() {
        return Inertia::render('Users/Index', ['users' => $this->service->getAllUsers()]);
    }

    public function create() {
        return Inertia::render('Users/Create');
    }

    public function show(User $user) {
        return Inertia::render('Users/Show', ['users' => $user]);
    }

    public function edit(User $user) {
        Gate::authorize('update', $user);
        return Inertia::render('Users/Edit', ['user' => $user]);
    }

    public function store(StoreUserRequest $request) {
        $this->service->createUser($request->validated());
        return to_route('users.index');
    }

    public function update(UpdateUserRequest $request, User $user) {
        Gate::authorize('update', $user);
        $user = $this->service->editUser($request->validated(), $user);
        if (auth()->user()->is_admin) return to_route('users.index')->with('success', 'User updated successfully!');
        return to_route('users.edit', $user)->with('success', 'Account updated successfully!');
    }

    public function destroy(User $user) {
        $this->service->deleteUser($user);
        return to_route('users.index');
    }

}
