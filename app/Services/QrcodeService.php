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

    public function getAll()
    {
        return $this->repository->getAll();
    }

    public function getById($id)
    {
        return $this->repository->findById($id);
    }

    public function create(array $data)
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
            $this->repository->delete($id);
            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
