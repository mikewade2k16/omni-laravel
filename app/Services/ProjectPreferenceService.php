<?php

namespace App\Services;

use App\Models\Project;
use App\Models\ProjectPreference;
use App\Models\User;

class ProjectPreferenceService
{
    public function updateOrCreateForUser(Project $project, User $user, array $settings)
    {
        return ProjectPreference::updateOrCreate(
            [
                'user_id' => $user->id,
                'project_id' => $project->id,
            ],
            [
                'settings' => $settings,
            ]
        );
    }
}