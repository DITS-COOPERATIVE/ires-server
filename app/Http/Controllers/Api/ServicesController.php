<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $Service = Service::all();
        
        if ($Service->count() > 0) {


            $Service = Service::all();

            if ($Service->count() > 0) {
    
            return $Service;

        } else {

            return response()->json([
                'status'    =>  404,
                'result'   => "No record found."
            ], 404);
        }
    }
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'          => 'required|string|max: 191',
            'type'          => 'required|string|max: 191',
            'description'   => 'required|string',
            'fee'           => 'required|numeric',
            'points'        => 'required|numeric',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status'    => 422,
                'errors'    => $validator->messages()
            ], 422);
        } else {
            $Service = Service::create([
                'name'          =>  $request->name,
                'type'          =>  $request->type,
                'description'   =>  $request->description,
                'fee'           =>  $request->fee,
                'points'        =>  $request->points
            ]);
            if ($Service) {

                return $Service;

            } else {

                return $Service;
            }
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $Service = Service::where('id', $id)->get();

        if ($Service) {

            return $Service;
            
        } else {

            return $Service;
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $Service = Service::find($id);
        if ($Service) {

            return $Service;

        } else {

            return $Service;
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'name'          => 'required|string|max: 191',
            'type'          => 'required|string|max: 191',
            'description'   => 'required|string',
            'fee'           => 'required|numeric',
            'points'        => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'    => 422,
                'errors'    => $validator->messages()
            ], 422);
        } else {

            $Service = Service::find($id);

            if ($Service) {

                $Service = Service::find($id)->update([
                    'name'          =>  $request->name,
                    'type'          =>  $request->type,
                    'description'   =>  $request->description,
                    'fee'           =>  $request->fee,
                    'points'        =>  $request->points
                ]);

                return $Service;

            } else {

                return $Service;
                
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $Service = Service::find($id);

        if ($Service) {

            $Service->delete();

            return $Service;

        } else {

            return $Service;
        }
    }
}
