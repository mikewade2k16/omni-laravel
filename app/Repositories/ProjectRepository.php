<?php

namespace App\Repositories;

use App\Models\Project;
use Illuminate\Support\Facades\Auth;

class ProjectRepository
{
    public function list()
    {
        $user = Auth::user();

        return Project::with(['creator', 'members'])
            ->where('visibility', 'public')
            ->orWhere(function ($query) use ($user) {
                $query->where('visibility', 'private')
                      ->where(function ($q) use ($user) {
                          $q->where('user_id', $user->id) 
                            ->orWhereHas('members', function ($subQ) use ($user) {
                                $subQ->where('user_id', $user->id);
                            });
                      });
            })
            ->orderBy('name', 'asc')
            ->get();
    }

    public function store(array $data)
    {
        return Project::create($data);
    }

    public function find($id)
    {
        return Project::with(['columns', 'creator', 'members'])->findOrFail($id);
    }

    public function update($id, array $data)
    {
        $project = Project::findOrFail($id);
        $project->update($data);
        return $project;
    }

    public function delete($id)
    {
        $project = Project::findOrFail($id);
        $project->delete();
    }
}