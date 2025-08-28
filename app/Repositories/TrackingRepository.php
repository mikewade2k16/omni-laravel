<?php

namespace App\Repositories;

use App\Models\Tracking;

class TrackingRepository
{
    public function list()
    {
        return Tracking::all();
    }

    public function store(array $data)
    {
        return Tracking::create($data);
    }

    public function find($id)
    {
        return Tracking::findOrFail($id);
    }

    public function update($id, array $data)
    {
        $tracking = Tracking::findOrFail($id);
        $tracking->update($data);
        return $tracking;
    }

    public function delete($id)
    {
        $tracking = Tracking::findOrFail($id);
        $tracking->delete();
    }
}
