<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\FilesOmni\StoreFilesOmniRequest;
use App\Http\Requests\FilesOmni\UpdateFilesOmniRequest;
use App\Http\Resources\FilesOmniResource;
use App\Services\FilesOmniService;

class FilesOmniController extends Controller
{
    protected $service;

    public function __construct(FilesOmniService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return FilesOmniResource::collection($this->service->allFiles());
    }

    public function store(StoreFilesOmniRequest $request)
    {
        $file = $this->service->createFile($request->validated());
        return new FilesOmniResource($file);
    }

    public function show($id)
    {
        $file = $this->service->getFile($id);
        return new FilesOmniResource($file);
    }

    public function update(UpdateFilesOmniRequest $request, $id)
    {
        $file = $this->service->updateFile($id, $request->validated());
        return new FilesOmniResource($file);
    }

    public function destroy($id)
    {
        $this->service->deleteFile($id);
        return response()->json(['message' => 'File deleted successfully.']);
    }
}
