<?php

namespace App\Http\Controllers\API\Employee;

use App\Models\Employee\Dependent;
use App\Models\Employee\Employee;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;


class DependentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $dependents = Dependent::all();

        return response()->json([
            'data' => $dependents
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
            $validator = Validator::make($request->all(), [
                'employee_id' => 'required',
                'name' => 'required',
                'last_name' => 'required',
                'dni' => 'required',
                'relationship' => 'required',
                'age' => 'required'
            ]);

            if ($validator->fails()) {
                throw new Exception($validator->errors(),504);
            }

            $dependents = Dependent::create($request->all());

              Employee::where('id', $request['employee_id'])
                ->with('dependent')->first();

            return response()->json([
                'data' => $dependents
            ]);
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
     * @param  int  $id
     * @return JsonResponse
     */
    public function show($id)
    {
        $dependents = Dependent::where('employee_id', $id)->get();

        return response()->json([
            'data' => $dependents
        ]);
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
            $validator = Validator::make($request->all(), [
                'employee_id' => 'required',
                'name' => 'required',
                'last_name' => 'required',
                'dni' => 'required',
                'relationship' => 'required',
                'age' => 'required|numeric'
            ]);

            if ($validator->fails()) {
                throw new Exception($validator->errors(),504);
            }

            $dependents = Dependent::create($request->all());

            Employee::where('id', $request['employee_id'])
                ->with('dependent')->first();

            return response()->json([
                'data' => $dependents
            ]);
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
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return void
     */
    public function destroy($id)
    {
        //
    }
}
