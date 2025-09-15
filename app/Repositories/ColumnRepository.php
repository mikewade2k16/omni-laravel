<?php

namespace App\Repositories;

use App\Models\Column;

class ColumnRepository
{
    public function list()
    {
        return Column::all();
    }

    public function store(array $data)
    {
        return Column::create($data);
    }

    public function find($id)
    {
        return Column::findOrFail($id);
    }

    public function update($id, array $data)
    {
        $column = Column::findOrFail($id);
        $column->update($data);
        return $column;
    }

    public function delete($id)
    {
        $column = Column::findOrFail($id);
        $column->delete();
    }
}