<?php

namespace App\Http\Controllers\API\Creditors;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Creditors\CreditorsHistoryModule;
use Exception;

class CreditorsHistoryModuleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $data = CreditorsHistoryModule::with('employee','user')->get();
        return response()->json([
            'message' => 'Listdo modulo histórico de acreedor',
            'data' => $data
        ], 200);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'CreditorsHistoryModule.index.failed',
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
