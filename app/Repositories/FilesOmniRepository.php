<?php

namespace App\Repositories;

use App\Models\FilesOmni;

class FilesOmniRepository
{
    protected $model;

    public function __construct(FilesOmni $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        return $this->model->all();
    }

    public function find($id)
    {
        return $this->model->findOrFail($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update($id, array $data)
    {
        $file = $this->find($id);
        $file->update($data);
        return $file;
    }

    public function delete($id)
    {
        $file = $this->find($id);
        return $file->delete();
    }
}
