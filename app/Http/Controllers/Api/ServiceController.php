<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ServiceValidationRequest;
use App\Models\Service;

class ServiceController extends Controller
{
    public function index()
    {
        $Service = Service::all();
        return $Service;
    }
    public function store(ServiceValidationRequest $request)
    {
        $validated = $request->validated();
        $Service = Service::create([
            ... $validated
        ]);
        return $Service;
    }
    public function show(Service $service)
    {
        return $service;
    }
    public function update(ServiceValidationRequest $request, Service $service)
    {
        $validated = $request->validated();
        $service->update([
            $validated
        ]);
        return $service;
    }
    public function destroy(Service $service)
    {
        $service->delete();
    }
}
