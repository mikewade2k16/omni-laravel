<?php

namespace App\Repositories;

use App\Models\ColumnHistory;

class ColumnHistoryRepository
{
    public function list()
    {
        return ColumnHistory::with(['oldColumn', 'newColumn'])->latest()->get();
    }

    public function store(array $data)
    {
        return ColumnHistory::create($data);
    }

    public function find($id)
    {
        return ColumnHistory::with(['oldColumn', 'newColumn'])->findOrFail($id);
    }

    public function update($id, array $data)
    {
        $history = ColumnHistory::findOrFail($id);
        $history->update($data);
        return $history;
    }

    public function delete($id)
    {
        $history = ColumnHistory::findOrFail($id);
        $history->delete();
    }
}