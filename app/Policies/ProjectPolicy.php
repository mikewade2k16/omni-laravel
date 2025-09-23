<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ProjectPolicy
{
    /**
     * Permite que um usuário crie um novo projeto.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Permite que um usuário veja um projeto específico.
     */
    public function view(User $user, Project $project): bool
    {
        return $project->visibility === 'public'
            || $user->id === $project->user_id
            || $project->members->contains($user);
    }

    /**
     * Permite que um usuário atualize um projeto.
     */
    public function update(User $user, Project $project): bool
    {
        return $user->id === $project->user_id
            || $project->members->contains($user);
    }

    /**
     * Permite que um usuário delete um projeto.
     */
    public function delete(User $user, Project $project): bool
    {
        return $user->id === $project->user_id;
    }
}