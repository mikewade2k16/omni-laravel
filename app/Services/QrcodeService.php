<?php

namespace App\Services;

use App\Repositories\QrcodeRepository;
use Illuminate\Support\Facades\DB;
use Exception;

class QrcodeService
{
    protected $repository;

    public function __construct(QrcodeRepository $repository)
    {
        $this->repository = $repository;
    }

    public function list()
    {
        return $this->repository->getAll();
    }

    public function find($id)
    {
        return $this->repository->find($id);
    }

    public function store(array $data)
    {
        DB::beginTransaction();
        try {
            $qrcode = $this->repository->create($data);
            DB::commit();
            return $qrcode;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function update($id, array $data)
    {
        DB::beginTransaction();
        try {
            $qrcode = $this->repository->update($id, $data);
            DB::commit();
            return $qrcode;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function delete($id)
    {
        DB::beginTransaction();
        try {
            $deleted = $this->repository->delete($id);
            DB::commit();
            return $deleted;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}