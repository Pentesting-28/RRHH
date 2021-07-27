<?php

namespace App\Http\Controllers\API\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Settings\Bank;
use Illuminate\Support\Facades\Validator;
use Exception;

class BankController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Bank::orderBy('name', 'asc')->get();

        return response()->json([
            'data' => $data
        ]);
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
            // return $request->all();
            // $this->validate_certificate($request[0]);

            $validator = Validator::make($request->all(), [
            'name' => 'required|unique:banks'
            ]);

            if ($validator->fails()) {
                throw new Exception($validator->errors(),504);
            }

            $bank = Bank::create($request->all());

            return response()->json([
                'data' => $bank,
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
        try {

            $validator = Validator::make($request->all(), [
            'name' => 'required|unique:banks'
            ]);

            if ($validator->fails()) {
                throw new Exception($validator->errors(),504);
            }


            Bank::findOrFail($id)
                ->update($request->all());

            $data = Bank::findOrFail($id);

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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Bank::findOrFail($id)->delete();

        $data = Bank::all();

        return response()->json([
            'data' => $data
        ]);
    }

}
