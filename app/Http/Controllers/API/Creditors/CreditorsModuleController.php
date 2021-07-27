<?php

namespace App\Http\Controllers\API\Creditors;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Creditors\CreditorsModule;
use App\Models\Creditors\CreditorsHistoryModule;
use Exception;
use Validator;

class CreditorsModuleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $data = CreditorsModule::with('type_expense','creditor','employee')->get();
            return response()->json([
                'message' => 'Lista de modulo acreedor',
                'data' => $data
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'error'  => 'CreditorsModule.index.failed',
                'message'=> $e->getMessage(),
            ], 505);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'string',
                'quantity' => 'required',
                'creditor_id' => 'required',
                'type_expense_id' => 'required',
                'employee_id' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'error'=>$validator->errors()
                ], 422);
            }
            $data = CreditorsModule::create($request->all());
            $request['user_id'] = auth()->id();
            $request['amount'] = $request->quantity;
            $request['action'] = 'creación'; // o store
            CreditorsHistoryModule::create($request->all());
            $data = CreditorsModule::where('id', $data->id)->with('type_expense','creditor','employee')->first();
            return response()->json([
                'message' => 'Modulo acreedor creado con éxito',
                'data' => $data
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'CreditorsModule.store.failed',
                'message'=> $e->getMessage()
            ], 505);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($employee_id)
    {
        try {
            $data = CreditorsModule::where('employee_id', $employee_id)->with('type_expense','creditor','employee')->get();
            return response()->json([
                "message" =>'Detalles de modulo acreedor',
                "data" => $data,
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'error'  => 'CreditorsModule.show.failed',
                'message'=> $e->getMessage(),
            ], 505);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'string',
                'quantity' => 'required',
                'creditor_id' => 'required',
                'type_expense_id' => 'required',
                'employee_id' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'error'=>$validator->errors()
                ], 422);
            }
            $data = CreditorsModule::findOrFail($id);
            $data->update($request->all());
            $request['user_id'] = auth()->id();
            $request['amount'] = $request->quantity;
            $request['action'] = 'actualización';
            CreditorsHistoryModule::create($request->all());
            $data = CreditorsModule::where('id', $data->id)->with('type_expense','creditor','employee')->first();
            return response()->json([
                'message' => 'Modulo acreedor actualizado con éxito',
                'data' => $data
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'CreditorsModule.update.failed',
                'message'=> $e->getMessage()
            ], 505);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $data = CreditorsModule::findOrFail($id);
            CreditorsHistoryModule::create([
                'user_id' => auth()->id(),
                'employee_id' => $data->employee_id,
                'amount'  => $data->quantity,
                'action'  => 'borrado'
            ]);
            $data->delete();
            return response()->json([
                'message' => 'Modulo acreedor eliminado con éxito',
                'data' => $data
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'CreditorsModule.destroy.failed',
                'message'=> $e->getMessage()
            ], 505);
        }
    }
}
