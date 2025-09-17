<?php

namespace App\Repositories;

use App\Models\Project;

class ProjectRepository
{
    public function list()
    {
        // Mantemos simples para a listagem geral
        return Project::orderBy('name', 'asc')->get();
    }

    public function store(array $data)
    {
        return Project::create($data);
    }

    public function find($id)
    {
        // ✅ AQUI ESTÁ A MUDANÇA: Carregamos as colunas junto com o projeto.
        return Project::with('columns')->findOrFail($id);
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