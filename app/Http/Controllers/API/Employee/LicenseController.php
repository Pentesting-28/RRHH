<?php

namespace App\Http\Controllers\API\Employee;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Employee\License;
use App\Http\Controllers\Controller;
use App\Models\Employee\Employee;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class LicenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $license = License::with('type_license')->get();

        return response()->json([
            'data' => $license
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
                'type_license_id' => 'required'
            ]);

            $array_license = explode(",", $request->type_license_id);

            $file = $request->file('license_path');

            $name = str_replace(" ", "_", $request['number']);
            $image = $this->saveImage($file, $name);

            $pathImage = $image['url'];

            $photo = config('app.url') . $pathImage;

            if ($validator->fails()) {
               throw new Exception($validator->errors(),504);
            }

            $license = License::create([
                'employee_id' => $request->employee_id,
                'number' => $request->number,
                'observation' => $request->observation,
                'license_path' => $photo,
                'expiration' => $request->expiration,
            ]);

            $license->type_license()->sync($array_license);

            $employee = Employee::where('id', $request['employee_id'])
                            ->with('license')->first();

            $data = License::where('id', $license->id)
                            ->with('type_license')
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
     * @param  int  $id
     * @return JsonResponse
     */
    public function show($id)
    {
        $license = License::where('employee_id', $id)
                            ->with('type_license')
                            ->get();

        return response()->json([
            'data' => $license
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
        // return $request->license_letter_id;
        try {
            $validator = Validator::make($request->all(), [
                'employee_id' => 'required',
                'number' => 'required',
                'observation' => 'nullable',
                'license_path' => 'nullable',
                'expiration' => 'required',
                'type_license_id' => 'required'
            ]);

            if ($validator->fails()) {
               throw new Exception($validator->errors(),504);
            }

            $array_license = explode(",", $request->type_license_id);

            $license = License::findOrFail($id);

            if (!is_string($request->license_path)) {
                $file = $request->file('license_path');

                $name = str_replace(" ", "_", $request['number']);
                $image = $this->saveImage($file, $name);

                $pathImage = $image['url'];

                $photo = config('app.url') . $pathImage;
            }else {
                $photo = $request->license_path;
            }

            $license->update([
                'employee_id' => $request->employee_id,
                'number' => $request->number,
                'observation' => $request->observation,
                'license_path' => $photo,
                'expiration' => $request->expiration,               
            ]);

            $license->type_license()->sync($array_license);


            $employee = Employee::where('id', $license->employee_id)
                            ->with('license')->first();

            $data = License::where('id', $id)
                            ->with('type_license')
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
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $license = License::findOrFail($id);
        $array_license = [];
        $license->type_license()->sync($array_license);
        $license = $license->delete();

        return response()->json([
            'data' => 'Eliminado con exito',
            'license' => $license
        ]);
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
