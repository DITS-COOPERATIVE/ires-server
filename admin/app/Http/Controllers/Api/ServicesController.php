<?php

namespace App\Http\Controllers;

use App\Models\Services;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ServicesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $services = Services::all();
        if ($services->count() > 0) {

            $data = [
                'status' => 200,
                'result' => $services
            ];
        } else {

            $data = [
                'status' => 404,
                'result' => 'No Records Found'
            ];
        }
        return view('services')->with(['result' => $data['result']]);
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
            $services = Services::create([
                'name'          =>  $request->name,
                'type'          =>  $request->type,
                'description'   =>  $request->description,
                'fee'           =>  $request->fee,
                'points'        =>  $request->points
            ]);
            if ($services) {

                $data = [
                    'status'    =>  200,
                    'message'   => "Service added successfully"
                ];
            } else {

                $data = [
                    'status'    =>  500,
                    'message'   => "Something went wrong!"
                ];
            }
            return redirect(route('products.index'))->with(['data' => $data]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $services = Services::where('id', $id)->get();

        if ($services) {
            $data = [
                'status' => 200,
                'result' => $services->flatten()->first(),
            ];
        } else {
            $data = [
                'status' => 404,
                'result' => "No Result Found.",
            ];
        }
        return view('services-view', [
            'services' => $data['result'],
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $services = Services::find($id);
        if ($services) {

            return response()->json([
                'status'    =>  200,
                'result'   => $services
            ], 200);
        } else {

            return response()->json([
                'status'    =>  404,
                'message'   => "No Data Found!"
            ], 404);
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

            $services = Services::find($id);

            if ($services) {

                $services = Services::find($id)->update([
                    'name'          =>  $request->name,
                    'type'          =>  $request->type,
                    'description'   =>  $request->description,
                    'fee'           =>  $request->fee,
                    'points'        =>  $request->points
                ]);

                return response()->json([
                    'status'    =>  200,
                    'message'   => "Service updated successfully"
                ], 200);
            } else {

                return response()->json([
                    'status'    =>  404,
                    'message'   => "Data not Found!"
                ], 404);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $services = Services::find($id);
        if ($services) {
            $services->delete();
            return response()->json([
                'status'    =>  200,
                'message'   => "Service deleted successfully!"
            ], 200);
        } else {

            return response()->json([
                'status'    =>  404,
                'message'   => "No Data Found!"
            ], 404);
        }
    }
}
