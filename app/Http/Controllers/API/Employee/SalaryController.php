<?php

namespace App\Http\Controllers\API\Employee;

use App\Models\Employee\Salary;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Employee\Employee;
use App\Models\Employee\SalaryHistoryModule;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class SalaryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $salary = Salary::orderBy('created_at', 'desc')->get();

        return response()->json([
            'data' => $salary
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
                'salary_type_id' => 'required',
                'salary' => 'required'
            ]);

            if ($validator->fails()) {
                throw new Exception($validator->errors(),504);
            }

            $salary = Salary::create($request->all());
            $request['user_id'] = auth()->id();
            $request['amount'] = $request->salary;
            $request['action'] = 'creación'; // o store
            SalaryHistoryModule::create($request->all());

            Employee::where('id', $request['employee_id'])
                    ->with('salary')->first();

            $data  = Salary::whereId($salary->id)
                            ->with('salary_type')
                            ->first();

            return response()->json([
                'data' => $data
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
     * @param int $id
     * @return JsonResponse
     */
    public function show($id)
    {
        $salary = Salary::where('employee_id', $id)
                            ->with('salary_type')
                            ->get();

        return response()->json([
            'data' => $salary
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
                'salary_type_id' => 'required',
                'salary' => 'required'
            ]);

            if ($validator->fails()) {
                throw new Exception($validator->errors(),504);
            }

            //modifique al metodo update(), ya que con el create() no actualiza, sino que crea un nueva registro.
            $salary = Salary::findOrFail($id);
            $salary->update($request->all());
            $request['user_id'] = auth()->id();
            $request['amount'] = $request->salary;
            $request['action'] = 'actualización';
            SalaryHistoryModule::create($request->all());

            Employee::where('id', $request['employee_id'])
                ->with('salary')->first();

            $data  = Salary::whereId($salary->id)
                            ->with('salary_type')
                            ->first();

            return response()->json([
                'data' => $data
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
     * @return JsonResponse
     */
    public function destroy($id)
    {
        // $salary = Salary::where('id', $id);
        $salary = Salary::findOrFail($id);
        SalaryHistoryModule::create([
            'user_id' => auth()->id(),
            'employee_id' => $salary->employee_id,
            'amount'  => $salary->salary,
            'action'  => 'borrado'
        ]);
        $salary->delete();
        return response()->json([
            'data' => 'Eliminado con exito',
            'salary' => $salary
        ]);
    }
}
