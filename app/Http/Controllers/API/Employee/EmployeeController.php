<?php

namespace App\Http\Controllers\API\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
// use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Employee\Employee;
use App\Models\Employee\Contact\Contact;
use App\Models\Employee\Address\Address;
use App\Models\Employee\Car;
use App\Models\Employee\Dependent;
use App\Models\Employee\Children\Children;
use App\Models\Employee\MedicalInformation\MedicalInformation;
use App\Models\Employee\OccupationData\OccupationData;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Exception;
use Validator;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $employee = Employee::with('license',
                                    'status_marital',
                                    'contact',
                                    'address.car',
                                    'dependent.children',
                                    'medical_information',
                                    'occupation_data.status_employee',
                                    'occupation_data.position')
                            ->orderBy('last_name', 'asc')
                            ->paginate(25);

        return response()->json([
            'data' => $employee
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
            DB::beginTransaction();

            $this->validatorGeneral($request->all());

            $employee = Employee::create(collect($request[0])->except(['photo','photo_dni'])->toArray() );
            $employee->contact()->create($request[1]);
            $address = $employee->address()->create($request[2]);

            $address->car()->create($request[3]);


            $dependent = $employee->dependent()->create($request[4]);

            foreach ($request[5]['children'] as $data_children) {
                $dependent->children()->create($data_children);
            }

            $employee->medical_information()->create($request[6]);

            $employee->occupation_data()->create($request[7]);

            $data = Employee::whereId($employee->id)
                                ->with('license',
                                        'status_marital',
                                        'contact',
                                        'address.car',
                                        'dependent.children',
                                        'medical_information',
                                        'occupation_data')
                                ->first();
            DB::commit();
            return response()->json([
                'data' => $data
            ]);
        } catch (Exception $e) {
            DB::rollBack();
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
        try {
            $employee = Employee::where('id', $id)
                                ->with('license',
                                    'status_marital',
                                    'contact',
                                    'address.car',
                                    'dependent.children',
                                    'medical_information',
                                    'occupation_data.status_employee',
                                    'occupation_data.position',
                                    'occupation_data.contract_termination',
                                    'occupation_data.contract_type',
                                    'occupation_data.status_employee',
                                    'occupation_data.payment_method',
                                    'occupation_data.bank',
                                    'occupation_data.department_type')
                                ->first();
        return response()->json([
            'message' => 'Detalle del empleado',
            'data' => $employee
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
     * @param Request $request
     * @param  int  $id
     * @return JsonResponse
     */
    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            // return $request->all();
            // $this->validate($request->all());
            $this->validatorGeneral($request->all(),$status='update',$id);
            $employee = Employee::findOrFail($id);

            $employee->update($request[0]);

            $employee->contact()->update($request[1]);
            $employee->address()->update($request[2]);   

            $address = $employee->address;

            $address->car()->update($request[3]);

            $employee->dependent()->update($request[4]);

            $dependent = $employee->dependent;

            $children_count = Children::where('dependent_id', $dependent->id)->count();

            if ($children_count > 0) {
               Children::where('dependent_id', $dependent->id)->delete();
            }

            foreach ($request[5]['children'] as $data_children) {
                $dependent->children()->create($data_children);                
            }

            $employee->medical_information()->update($request[6]);

            $employee->occupation_data()->update($request[7]);

            if ( isset($request[7]['contract_termination_id']) ) {
                $employee->occupation_data()->update([
                    'status_employee_id' => 2
                ]);                
            }else {
                $employee->occupation_data()->update([
                    'contract_termination_id' => null
                ]);  
            }

            DB::commit();

            $data = Employee::whereId($id)
                                    ->with('license',
                                        'status_marital',
                                        'contact',
                                        'address.car',
                                        'dependent.children',
                                        'medical_information',
                                        'occupation_data')
                                    ->first();

            return response()->json([
                'data' => $data
            ]);
        } catch (Exception $e) {
            DB::rollBack();
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
        //
    }

    public function imageEmployee(Request $request, $id)
    {
        // return $request->photo;
        try {
            
            $employee = Employee::findOrFail($id);
            

            if (!is_string($request->photo) && $request->photo !== null) {

                $file = $request->file('photo');

                $name = str_replace(" ", "_", $employee['name'].$employee['last_name']);
                $image = $this->saveImage($file, $name);

                $pathImage = $image['url'];

                $photo = config('app.url') . $pathImage;                
            }else {
                $photo = $request->photo;
            }

            if (!is_string($request->photo_dni) && $request->photo_dni !== null) {
                $file = $request->file('photo_dni');
                $name = str_replace(" ", "_", $employee['dni']);
                $image = $this->saveImage($file, $name);

                $pathImage = $image['url'];

                $photo_dni = config('app.url') . $pathImage;
            }else {
                $photo_dni = $request->photo_dni;
            }


            if ($request->photo !== 'null') {
                $employee->update([
                    'photo' => $photo
                ]);
            }

            if ($request->photo_dni !== 'null') {
                $employee->update([
                    'photo_dni' =>  $photo_dni
                ]);
            }


            $data = Employee::whereId($id)
                                        ->with('license',
                                            'status_marital',
                                            'contact',
                                            'address.car',
                                            'dependent.children',
                                            'medical_information',
                                            'occupation_data')
                                        ->first();

            return response()->json([
                    'data' => $data
                ]);
        } catch (Exception $e) {
            return response()->json([
                    "message" => $e->getMessage()
                ], 422);
        }


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
    //             'name' => 'required',
    //             'middle_name' => 'required',
    //             'last_name' => 'required',
    //             'second_surname' => 'required',
    //             'dni' => 'required',
    //             'position' => 'required',
    //             'contract_type' => 'required',
    //             'start_contract' => 'required',
    //             'probationary_period' => 'required',
    //             'end_contract' => 'required',
    //             'payment_method_id' => 'required',
    //             'department_type_id' => 'required',
    //         ]);

    //         if ($validator->fails()) {
    //             throw new Exception($validator->errors(),504);
    //         }
    // }

    public function image($filename)
    {
        return Storage::download('public/Image/'.$filename);
    }

    public function searchEmployee(Request $request)
    {
        $data = Employee::where('name','LIKE',"%$request->name%")
                            ->with('license',
                                    'status_marital',
                                    'contact',
                                    'address.car',
                                    'dependent.children',
                                    'medical_information',
                                    'occupation_data.status_employee')
                            ->orderBy('name', 'asc')
                            ->paginate(25);

        return response()->json([
            'data' => $data
            ]);
        
    }

    public function validatorGeneral($data,$status='create',$id=0)
    {
        $validator_employee = Validator::make($data[0], [
                  'name' => 'required',
                  'middle_name' => 'nullable',
                  'last_name' => 'nullable',
                  'second_surname' => 'nullable',
                  'dni' => 'nullable',
                  'photo_dni' => 'nullable',
                  'photo' => 'nullable',
                  'status_marital_id' => 'required',
            ]);

            if ($status == 'update') {
                $validator_contact = Validator::make($data[1], [
                    'tlf_home' => 'nullable',
                    'tlf_movil' => 'required',
                    'email' => "unique:contacts,email,$id|nullable",
                ]);                
            }else {
                $validator_contact = Validator::make($data[1], [
                    'tlf_home' => 'nullable',
                    'tlf_movil' => 'required',
                    'email' => 'unique:contacts|nullable',
                ]);                
            }


            $validator_address = Validator::make($data[2], [
                'name' => 'required',
                'status_car' => 'required',
            ]);

            $validator_car = Validator::make($data[3], [
                'driver_license' => 'required',
                'brand' => 'nullable',
                'model' => 'nullable',
                'license_plate' => 'nullable',
            ]);

            $validator_dependent = Validator::make($data[4], [
                'name_father'   => 'nullable',
                'name_mother'   => 'nullable',
                'name_spouse'   => 'nullable',
                'date_spouse'   => 'nullable',
                'spouse_job'    => 'nullable',
                'spouse_position'   => 'nullable',
                'family_business'   => 'required',
                'urgency_notify'    => 'required',
                'urgency_relationship'  => 'required',
                'urgency_res'   => 'required',
                // 'urgency_office'    => 'nullable',
                'urgency_address'   => 'required',
                'children_status'   => 'required',
            ]);

            if ($data[4]['children_status'] == 'Si') {
                foreach ($data[5]['children'] as $key => $value) {
                    $validator_children = Validator::make($value, [
                        'name' => 'required',
                        'dependent' => 'required',
                        'gender' => 'required',
                    ]);
                }
            }

            $validator_medical_information = Validator::make($data[6], [
                'height' => 'nullable',
                'weight' => 'nullable',
                'blood_type' => 'required',
                'donor' => 'required',
                'hospitalized' => 'required',
                'hospitalized_explain' => 'nullable',
                'disease' => 'required',
                'disease_explain' => 'nullable',
                'treatment' => 'required',
                'treatment_explain' => 'nullable',
                'allergic' => 'required',
                'allergic_explain' => 'nullable',
                'lenses' => 'required',
                'hearing' => 'required',
                'drugs' => 'required',
                'drugs_explain' => 'nullable',
                'psychiatric' => 'required',
                'psychiatric_explain' => 'nullable',
            ]);

            $validator_occupation_data = Validator::make($data[7], [
                'position_id' => 'required',
                'contract_type_id' => 'required',
                'status_employee_id' => 'required',
                'start_contract' => 'required',
                'contract_termination_id' => 'nullable',
                'end_your_contract' => 'nullable',
                'probationary_period' => 'required',
                'end_contract' => 'nullable',
                'payment_method_id' => 'required',
                'department_type_id' => 'required',
                'shirt' => 'nullable',
                'trousers' => 'nullable',
                'dress' => 'nullable',
                'footwear' => 'nullable',
                'account_number' => 'required',
                'bank_id' => 'required',
            ]);

            if ($validator_employee->fails()) {
               throw new Exception($validator_employee->errors(),504);
            }

            if ($validator_contact->fails()) {
               throw new Exception($validator_contact->errors(),504);
            }

            if ($validator_address->fails()) {
               throw new Exception($validator_address->errors(),504);
            }

            if ($validator_car->fails()) {
               throw new Exception($validator_car->errors(),504);
            }

            if ($validator_dependent->fails()) {
               throw new Exception($validator_dependent->errors(),504);
            }

            if ($data[4]['children_status'] == 'Si') {
                if ($validator_children->fails()) {
                   throw new Exception($validator_children->errors(),504);
                }
            }

            if ($validator_medical_information->fails()) {
               throw new Exception($validator_medical_information->errors(),504);
            }

            if ($validator_occupation_data->fails()) {
               throw new Exception($validator_occupation_data->errors(),504);
            }
    }
}
