<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\SiteZenService;
use App\Http\Requests\SiteZen\StoreSiteZenRequest;
use App\Http\Requests\SiteZen\UpdateSiteZenRequest;
use App\Http\Resources\SiteZenResource;

class SiteZenController extends Controller
{
    protected $service;

    public function __construct(SiteZenService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $siteZens = $this->service->getAll();
        return SiteZenResource::collection($siteZens);
    }

    public function show($id)
    {
        $siteZen = $this->service->getById($id);
        return new SiteZenResource($siteZen);
    }

    public function store(StoreSiteZenRequest $request)
    {
        $siteZen = $this->service->create($request->validated());
        return new SiteZenResource($siteZen);
    }

    public function update(UpdateSiteZenRequest $request, $id)
    {
        $siteZen = $this->service->update($id, $request->validated());
        return new SiteZenResource($siteZen);
    }

    public function destroy($id)
    {
        $this->service->delete($id);
        return response()->json(['message' => 'SiteZen deletado com sucesso.']);
    }
}
