<?php

namespace App\Http\Controllers\API\Settings;

use App\Models\Settings\DepartmentType;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $data = DepartmentType::orderBy('name', 'asc')->get();

        return response()->json([
            'data' => $data
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        try {
            // return $request->all();
            // $this->validate_certificate($request[0]);
            $this->validate($request->all());

            $unit = DepartmentType::create($request->all());

            return response()->json([
                'data' => $unit,
            ], 200);
        } catch (Exception $e) {

            if ($e->getCode() == 504) {
                # code...
                return response()->json([
                    "message" => json_decode($e->getMessage())
                ], 422);
            } else{
                return response()->json([
                    "message" => $e->getMessage()
                ], 422);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return void
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return JsonResponse
     */
    public function update(Request $request, $id)
    {
        try {

            $this->validate($request->all());


            DepartmentType::findOrFail($id)
                ->update($request->all());

            $data = DepartmentType::findOrFail($id);

            return response()->json([
                'data' => $data
            ], 200);
        } catch (Exception $e) {

            if ($e->getCode() == 504) {
                # code...
                return response()->json([
                    "message" => json_decode($e->getMessage())
                ], 422);
            } else {
                return response()->json([
                    "message" => $e->getMessage()
                ], 422);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        DepartmentType::findOrFail($id)->delete();;


        $data = DepartmentType::all();

        return response()->json([
            'data' => $data
        ]);
    }

    public function validate($data)
    {
        $validator = Validator::make($data, [
            'name' => 'required'

        ]);

        if ($validator->fails()) {
            throw new Exception($validator->errors(),504);
        }
    }
}
