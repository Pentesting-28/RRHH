<?php

namespace App\Http\Controllers\API\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Settings\DrivingLicense;
use Illuminate\Support\Facades\Validator;
use Exception;
use Illuminate\Support\Facades\Storage;

class DrivingLicenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $driving_license = DrivingLicense::all();

        return response()->json([
            'data' => $driving_license
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
                'number' => 'required',
                'observation' => 'nullable',
                'license_path' => 'nullable',
                'expiration' => 'required',
                'license_types_id' => 'required',
            ]);

            $file = $request->file('license_path');

            $name = str_replace(" ", "_", $request['number']);
            $image = $this->saveImage($file, $name);

            $pathImage = $image['url'];

            $photo = config('app.url') . $pathImage;

            if ($validator->fails()) {
               throw new Exception($validator->errors(),504);
            }

            $driving_license = DrivingLicense::create([
                'employee_id' => $request->employee_id,
                'number' => $request->number,
                'observation' => $request->observation,
                'license_path' => $photo,
                'expiration' => $request->expiration,
                'license_types_id' => $request->license_types_id,
            ]);

            // $employee = Employee::where('id', $request['employee_id'])
            //                 ->with('license')->first();

            return response()->json([
                'data' => $driving_license
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
        $driving_license = DrivingLicense::where('employee_id', $id)->get();

        return response()->json([
            'data' => $driving_license
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
                'number' => 'required',
                'observation' => 'nullable',
                'license_path' => 'nullable',
                'expiration' => 'required',
                'license_types_id' => 'required',               
            ]);

            if ($validator->fails()) {
               throw new Exception($validator->errors(),504);
            }

            $driving_license = DrivingLicense::findOrFail($id);

            if (!is_string($request->license_path)) {
                $file = $request->file('license_path');

                $name = str_replace(" ", "_", $request['number']);
                $image = $this->saveImage($file, $name);

                $pathImage = $image['url'];

                $photo = config('app.url') . $pathImage;
            }else {
                $photo = $request->license_path;
            }

            $driving_license->update([
                'employee_id' => $request->employee_id,
                'number' => $request->number,
                'observation' => $request->observation,
                'license_path' => $photo,
                'expiration' => $request->expiration,   
                'license_types_id' => $request->license_types_id,
            ]);

            // $employee = Employee::where('id', $driving_license->employee_id)
            //                 ->with('license')->first();

            return response()->json([
                'data' => $driving_license
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
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $driving_license = DrivingLicense::findOrFail($id);
        $driving_license->delete();
    }

    public function saveImage($file, $name)
    {
        // extension del archivo
        $fileExtension = $file->getClientOriginalExtension();
        //obtenemos el nombre del archivo
        $filename = $name . time();
        // guardo el archivo
        $path = Storage::disk('local')->putFileAs('public/Image', $file, "$filename.$fileExtension");
        // obteniendo la url;
        $url = Storage::disk('local')->url($path);

        $array  = collect([
            'photo_name' => "$filename.$fileExtension",
            'url' => $url
        ]);

        return $array;
    }

    // public function validate($data)
    // {
    //     $validator = Validator::make($data, [
    //             'employee_id' => 'required',
    //             'number' => 'required',
    //             'observation' => 'nullable',
    //             'validity' => 'required',
    //             'license_path' => 'nullable',
    //             'expiration' => 'required',
    //             'done' => 'required',
    //         ]);

    //         if ($validator->fails()) {
    //             throw new Exception($validator->errors(),504);
    //         }
    // }
}
