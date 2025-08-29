<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ShortLink\StoreShortLinkRequest;
use App\Http\Requests\ShortLink\UpdateShortLinkRequest;
use App\Http\Resources\ShortLinkResource;
use App\Services\ShortLinkService;
use Illuminate\Http\Request;

class ShortLinkController extends Controller
{
    protected $service;

    public function __construct(ShortLinkService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $shortLinks = $this->service->list();
        return ShortLinkResource::collection($shortLinks);
    }

    public function store(StoreShortLinkRequest $request)
    {
        $shortLink = $this->service->create($request->validated());
        return new ShortLinkResource($shortLink);
    }

    public function show($id)
    {
        $shortLink = $this->service->get($id);
        return new ShortLinkResource($shortLink);
    }

    public function update(UpdateShortLinkRequest $request, $id)
    {
        $shortLink = $this->service->update($id, $request->validated());
        return new ShortLinkResource($shortLink);
    }

    public function destroy($id)
    {
        $this->service->delete($id);
        return response()->json(['message' => 'ShortLink deleted successfully']);
    }
}
