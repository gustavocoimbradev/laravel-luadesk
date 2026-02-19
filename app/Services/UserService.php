<?php 

namespace App\Services;

use App\Models\User;

class UserService {

    public function getAllUsers() {
        return User::orderBy('id', 'desc')->get();
    }

    public function createUser(array $data) {
        return User::create($data);
    }

    public function editUser(array $data, User $user) {
        $user->update($data);
        return $user;
    }

    public function deleteUser(User $user) {
        $user->delete();
    }

}