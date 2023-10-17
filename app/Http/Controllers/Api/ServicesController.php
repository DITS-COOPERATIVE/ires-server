<?php

namespace App\Http\Controllers;

use App\Http\Requests\Api\ServiceValidationRequest;
use App\Models\Service;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $Service = Service::all();
        
        return response()->json([
            'result'   => $Service,
        ]);
    }

    public function store(ServiceValidationRequest $request)
    {
        $validated = $request->validated();

        $Service = Service::create([
            $validated
        ]);

        return response()->json([
            'result'   => $Service,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $Service = Service::where('id', $id);

        return response()->json([
            'result'   => $Service,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ServiceValidationRequest $request, string $id)
    {
        $validated = $request->validated();

        $Service = Service::find($id)->update([
            $validated
        ]);

        return response()->json([
            'result'   => $Service,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $Service = Service::find($id)->delete();

        return response()->json([
            'result'   => $Service,
        ]);
    }
}
