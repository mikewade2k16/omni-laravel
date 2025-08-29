<?php

namespace App\Repositories;

use App\Models\SiteZen;

class SiteZenRepository
{
    protected $model;

    public function __construct(SiteZen $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        return $this->model->all();
    }

    public function find(int $id)
    {
        return $this->model->findOrFail($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data)
    {
        $item = $this->find($id);
        $item->update($data);
        return $item;
    }

    public function delete(int $id)
    {
        $item = $this->find($id);
        return $item->delete();
    }
}
