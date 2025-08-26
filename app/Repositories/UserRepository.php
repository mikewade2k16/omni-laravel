<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    public function list() { return User::all(); }
    public function store(array $data) { return User::create($data); }
    public function find($id) { return User::findOrFail($id); }
    public function update($id, array $data)
    {
        $user = User::findOrFail($id);
        $user->update($data);
        return $user;
    }
    public function delete($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
    }
}
