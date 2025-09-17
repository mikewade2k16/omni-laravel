<?php

namespace App\Services;

use App\Models\Column;
use Illuminate\Database\Eloquent\Collection;

class ColumnService
{
    /**
     * Lista todas as colunas.
     */
    public function list(): Collection
    {
        return Column::all();
    }

    /**
     * Encontra uma coluna pelo seu ID.
     */
    public function find(int $id): Column
    {
        return Column::findOrFail($id);
    }

    /**
     * Cria uma nova coluna.
     */
    public function store(array $data): Column
    {
        return Column::create($data);
    }

    /**
     * Atualiza uma coluna existente.
     */
    public function update(int $id, array $data): Column
    {
        $column = $this->find($id);
        $column->update($data);
        return $column;
    }

    /**
     * Deleta uma coluna.
     */
    public function delete(int $id): bool
    {
        $column = $this->find($id);
        return $column->delete();
    }
}