<?php

namespace App\Http\Controllers\API\Creditors;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Creditors\Creditor;
use Exception;
use Validator;

class CreditorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $data = Creditor::orderBy('name', 'asc')->get();
            return response()->json([
                'error' => 'Lista de acreedor',
                'data' => $data
            ]);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'creditor.index.failed',
                'message' => $e->getMessage()
            ]);
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
                'name' => 'required|string'
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'error'=>$validator->errors()
                ], 422);
            }
            $data = Creditor::create($request->all());
            return response()->json([
                'message' => 'Acreedor creado con éxito',
                'data' => $data
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'creditor.store.failed',
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
            $data = Creditor::findOrFail($id);
            return response()->json([
                'message' => 'Detalles de acreedor',
                'data' => $data
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'creditor.show.failed',
                'message'=> $e->getMessage()
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
                'name' => 'required|string'
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'error'=>$validator->errors()
                ], 422);
            }
            $data = Creditor::findOrFail($id);
            $data->update($request->all());
            return response()->json([
                'message' => 'Acreedor actualizado con éxito',
                'data' => $data
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'creditor.update.failed',
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
            $data = Creditor::findOrFail($id);
            $data->delete();
            return response()->json([
                'message' => 'Acreedor eliminado con éxito',
                'data' => $data
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'creditor.destroy.failed',
                'message'=> $e->getMessage()
            ], 505);
        }
    }
}
