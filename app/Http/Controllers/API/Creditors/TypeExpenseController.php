<?php

namespace App\Http\Controllers\API\Creditors;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Creditors\TypeExpense;
use Exception;
use Validator;

class TypeExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $data = TypeExpense::orderBy('name', 'asc')->get();
            return response()->json([
                'message' => 'Lista de gastos',
                'data' => $data 
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'TypeExpense.index.failed',
                'message'=> $e->getMessage()
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
                'name' => 'required|string|unique:type_expenses'
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'error'=>$validator->errors()
                ], 422);
            }
            $data = TypeExpense::create($request->all());
            return response()->json([
                'message' => 'Tipo de gasto creado con éxito',
                'data' => $data
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'TypeExpense.store.failed',
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
    public function show($id)
    {
        try {
            $data = TypeExpense::findOrFail($id);
            return response()->json([
                'message' => 'Detalles del tipo de gasto',
                'data' => $data
            ]);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'TypeExpense.show.failed',
                'message' => $e->getMessage()
            ]);
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
                'name' => "required|string|unique:type_expenses,name,$id"
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'error'=>$validator->errors()
                ], 422);
            }
            $data = TypeExpense::findOrFail($id);
            $data->update($request->all());
            return response()->json([
                'message' => 'Tipo de gasto actualizado con éxito',
                'data' => $data
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'TypeExpense.update.failed',
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
            $data = TypeExpense::findOrFail($id);
            $data->delete();
            return response()->json([
                'message' => 'Gasto eliminado con éxito',
                'data' => $data
            ]);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'TypeExpense.destroy.failed',
                'message' => $e->getMessage()
            ]);
        }
    }
}
