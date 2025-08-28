<?php

namespace App\Repositories;

use App\Models\Project;

class ProjectRepository
{
    public function list()
    {
        return Project::all();
    }

    public function store(array $data)
    {
        return Project::create($data);
    }

    public function find($id)
    {
        return Project::findOrFail($id);
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
