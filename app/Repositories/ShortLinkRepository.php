<?php

namespace App\Repositories;

use App\Models\ShortLink;

class ShortLinkRepository
{
    protected $model;

    public function __construct(ShortLink $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        return $this->model->with('client')->get();
    }

    public function find(int $id)
    {
        return $this->model->with('client')->findOrFail($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data)
    {
        $shortLink = $this->find($id);
        $shortLink->update($data);
        return $shortLink;
    }

    public function delete(int $id)
    {
        $shortLink = $this->find($id);
        return $shortLink->delete();
    }
}
