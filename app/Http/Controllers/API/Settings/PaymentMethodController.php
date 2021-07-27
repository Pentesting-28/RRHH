<?php

namespace App\Http\Controllers\API\Settings;

use App\Models\Settings\PaymentMethod;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class PaymentMethodController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $data = PaymentMethod::orderBy('name', 'asc')->get();

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

            $unit = PaymentMethod::create($request->all());

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
     * @param  int  $id
     * @return Response
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


            PaymentMethod::findOrFail($id)
                ->update($request->all());

            $data = PaymentMethod::findOrFail($id);

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
     * @return JsonResponse
     */
    public function destroy($id)
    {
        PaymentMethod::findOrFail($id)->delete();;


        $data = PaymentMethod::all();

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
