<?php

namespace App\Repositories;

use App\Models\Qrcode;
use Illuminate\Support\Collection;

class QrcodeRepository
{
    protected $model;

    public function __construct(Qrcode $qrcode)
    {
        $this->model = $qrcode;
    }

    /**
     * Retorna todos os QRCodes
     */
    public function getAll(): Collection
    {
        return $this->model->all();
    }

    /**
     * Cria um novo QRCode
     */
    public function create(array $data): Qrcode
    {
        return $this->model->create($data);
    }

    /**
     * Busca um QRCode pelo ID
     */
    public function find(int $id): ?Qrcode
    {
        return $this->model->find($id);
    }

    /**
     * Atualiza um QRCode
     */
    public function update(int $id, array $data): ?Qrcode
    {
        $qrcode = $this->find($id);

        if ($qrcode) {
            $qrcode->update($data);
        }

        return $qrcode;
    }

    /**
     * Deleta um QRCode
     */
    public function delete(int $id): bool
    {
        $qrcode = $this->find($id);

        if ($qrcode) {
            return (bool) $qrcode->delete();
        }

        return false;
    }
}
