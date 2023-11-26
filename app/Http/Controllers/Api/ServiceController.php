<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ServiceRequest;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        return Service::all();
    }

    public function show(Service $service)
    {
        return $service;
    }

    public function store(ServiceRequest $request)
    {
        return Service::create($request->validated());
    }

    public function update(ServiceRequest $request, Service $service)
    {
        $service->update($request->validated());

        return $service;
    }

    public function destroy(Service $service)
    {
        $service->delete();
    }
}
