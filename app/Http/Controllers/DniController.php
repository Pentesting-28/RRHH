<?php

namespace App\Http\Controllers;

use App\Models\Employee\Dni;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Exception;
use Validator;

class DniController extends Controller
{
     public function index()
    {
        $driving_license = Dni::all();

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

        // return $request->all();

        try {
            $validator = Validator::make($request->all(), [
                'employee_id' => 'required',
                'number' => 'required',
                'expiration' => 'required',
                'status_dni' => 'required',
            ]);

            if ($validator->fails()) {
               throw new Exception($validator->errors(),504);
            }

            if (!is_string($request->photo_dni) && $request->photo_dni !== null) {      
                $file = $request->file('photo_dni');

                $name = str_replace(" ", "_", $request['number']);
                $image = $this->saveImage($file, $name);

                $pathImage = $image['url'];

                $photo = config('app.url') . $pathImage;

                $driving_license = Dni::create([
                'employee_id' => $request->employee_id,
                'number' => $request->number,
                'status_dni' => $request->status_dni,
                'photo_dni' => $photo,
                'expiration' => $request->expiration,
                ]);
            }else{

                $driving_license = Dni::create([
                    'employee_id' => $request->employee_id,
                    'number' => $request->number,
                    'status_dni' => $request->status_dni,
                    'expiration' => $request->expiration,
                ]);
            } 


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
        $driving_license = Dni::where('employee_id', $id)->get();

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
                'employee_id' => 'required',
                'number' => 'required',
                'expiration' => 'required',
                'status_dni' => 'required',
            ]);

            if ($validator->fails()) {
               throw new Exception($validator->errors(),504);
            }

            $driving_license = Dni::findOrFail($id);

            if (!is_string($request->photo_dni)) {
                $file = $request->file('photo_dni');

                $name = str_replace(" ", "_", $request['number']);
                $image = $this->saveImage($file, $name);

                $pathImage = $image['url'];

                $photo = config('app.url') . $pathImage;
            }else {
                $photo = $request->photo_dni;
            }

            $driving_license->update([
                'employee_id' => $request->employee_id,
                'number' => $request->number,
                'status_dni' => $request->status_dni,
                'photo_dni' => $photo,
                'expiration' => $request->expiration,
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

    public function update_dni(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'employee_id' => $request->employee_id,
                'number' => $request->number,
                'status_dni' => $request->status_dni,
                'photo_dni' => $photo,
                'expiration' => $request->expiration,
            ]);

            if ($validator->fails()) {
               throw new Exception($validator->errors(),504);
            }

            $driving_license = Dni::findOrFail($id);

            if (!is_string($request->license_path)) {
                $file = $request->file('photo_dni');

                $name = str_replace(" ", "_", $request['number']);
                $image = $this->saveImage($file, $name);

                $pathImage = $image['url'];

                $photo = config('app.url') . $pathImage;

                $driving_license->update([
                    'employee_id' => $request->employee_id,
                    'number' => $request->number,
                    'status_dni' => $request->status_dni,
                    'photo_dni' => $photo,
                    'expiration' => $request->expiration,
                ]);
            }else {
                $driving_license->update([
                    'employee_id' => $request->employee_id,
                    'number' => $request->number,
                    'status_dni' => $request->status_dni,
                    'expiration' => $request->expiration,
                ]);
            }


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
        $driving_license = Dni::findOrFail($id);
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
}
