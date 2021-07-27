<?php

namespace App\Http\Controllers\API\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee\Employee;
use App\Models\Employee\License;
use App\Models\Creditors\CreditorsModule;
use Exception;
use PDF;
use Carbon\Carbon;

class FilteredOutPDFController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function FilteredOutPDF(Request $request,$opc,$department,$position)
    {
        try {

            if( $department < 1 ){ $department = 0; }
            if( $position   < 1 ){ $position   = 0; }

            switch ($opc) {
                case 1:/*Tipos de Sangre/Filtros/Departamento/Posiciones/PDF*/
                   $data = Employee::when($department > 0, function ( $query ) use ( $department ) {
                                    $query->whereHas('occupation_data', function ( $query ) use ( $department ){
                                             $query->where('department_type_id',$department);
                                       });
                                    })
                                    ->when($position > 0, function ( $query ) use ( $position ) {
                                     $query->whereHas('occupation_data', function ( $query ) use ( $position ){
                                             $query->where('position_id',$position);
                                       });
                                    })
                                    ->when($request->has('blood_type') , function ( $query ) use ( $request ) {
                                     $query->whereHas('medical_information', function ( $query ) use ( $request ){
                                             $query->where('blood_type','LIKE',"%$request->blood_type%");
                                       });
                                    })
                                    ->select(['id','name','last_name','dni'])
                                    ->has('medical_information')
                                    ->with('medical_information:id,employee_id,blood_type') 
                                    ->get();
                    return $pdf = PDF::loadView('Reports.PdfBloodType', compact('data'))
                                    ->stream('Tipos de Sangre.pdf');
                break;
                case 2:/*Padecimientos(Enfermedades)/Filtros/Departamento/Posiciones/PDF*/
                    $data = Employee::when($department > 0, function ( $query ) use ( $department ) {
                                    $query->whereHas('occupation_data', function ( $query ) use ( $department ){
                                             $query->where('department_type_id',$department);
                                       });
                                    })
                                    ->when($position > 0, function ( $query ) use ( $position ) {
                                     $query->whereHas('occupation_data', function ( $query ) use ( $position ){
                                             $query->where('position_id',$position);
                                       });
                                    })
                                    ->select(['id','name','last_name','dni'])
                                    ->has('medical_information')
                                    ->with('medical_information:id,employee_id,disease')
                                    ->get();
                    return $pdf = PDF::loadView('Reports.PdfAilments', compact('data'))
                                    ->stream('Padecimientos(Enfermedades).pdf');
                break;
                case 3:/*Carné de Salud(Blanco y Verde)*/
                    $data = Employee::when($department > 0, function ( $query ) use ( $department ) {
                                     $query->whereHas('occupation_data', function ( $query ) use ( $department ){
                                             $query->where('department_type_id',$department);
                                       });
                                    })
                                    ->when($position > 0, function ( $query ) use ( $position ) {
                                     $query->whereHas('occupation_data', function ( $query ) use ( $position ){
                                             $query->where('position_id',$position);
                                       });
                                    })
                                    ->when($request->has('license_types_id'), function ( $query ) use ( $request ) {
                                     $query->whereHas('driving_license', function ( $query ) use ( $request ){
                                             $query->where('license_types_id',$request->license_types_id);
                                       });
                                    })
                                    ->when($request->has('expiration'), function ( $query ) use ( $request ) {
                                     $query->whereHas('driving_license', function ( $query ) use ( $request ){
                                             $query->whereDate('expiration',$request->expiration);
                                       });
                                    })
                                    ->select(['id','name','last_name','dni'])
                                    ->has('driving_license')
                                    ->with(['driving_license:id,employee_id,created_at,expiration,license_path,license_types_id','driving_license.license_types:id,name'])
                                    ->get();
                    return $pdf = PDF::loadView('Reports.PdfHealthCard', compact('data'))
                                    ->stream('Carné de Salud(Blanco y Verde).pdf');
                break;
                case 4:/*Licencias de Conducir*/
                    $data = License::when($department > 0, function ( $query ) use ( $department ) {
                                    $query->whereHas('employee.occupation_data', function ( $query ) use ( $department ){
                                             $query->where('department_type_id',$department);
                                       });
                                    })
                                    ->when($position > 0, function ( $query ) use ( $position ) {
                                     $query->whereHas('employee.occupation_data', function ( $query ) use ( $position ){
                                             $query->where('position_id',$position);
                                       });
                                    })
                                    ->when($request->has('expirationLicense'), function ( $query ) use ( $request ) {
                                     $query->whereHas('type_license', function ( $query ) use ( $request ){
                                             $query->whereDate('expiration',$request->expirationLicense);
                                       });
                                    })
                                    ->select(['id','employee_id','expiration','license_path'])
                                    ->has('type_license')
                                    ->with(['type_license','employee:id,name,last_name,dni'])
                                    ->get();
                    return $pdf = PDF::loadView('Reports.PdfDriversLicenses', compact('data'))
                                    ->stream('Licencias de Conducir.pdf');
                break;        
                case 5:/*Placas/Filtros/Departamento/PDF*/
                    $data = Employee::when($department > 0, function ( $query ) use ( $department ) {
                                    $query->whereHas('occupation_data', function ( $query ) use ( $department ){
                                             $query->where('department_type_id',$department);
                                       });
                                    })
                                    ->when($position > 0, function ( $query ) use ( $position ) {
                                     $query->whereHas('occupation_data', function ( $query ) use ( $position ){
                                             $query->where('position_id',$position);
                                       });
                                    })
                                    ->select(['id','name','last_name','dni'])
                                    ->with(['address:id,employee_id'])
                                    ->with(['address.car' => function ($query) {
                                        $query->where('brand', '!=', null);
                                    }])
                                    ->whereHas('address.car', function ($query) {
                                        $query->where('brand', '!=', null);
                                    })
                                    ->get();
                    return $pdf = PDF::loadView('Reports.PdfPlates', compact('data'))
                                     ->stream('Placas.pdf');
                break;
                case 6:/*Cédulas/Filtros/Departamento/PDF*/
                    $data = Employee::when($department > 0, function ( $query ) use ( $department ) {
                                    $query->whereHas('occupation_data', function ( $query ) use ( $department ){
                                             $query->where('department_type_id',$department);
                                       });
                                    })
                                    ->when($position > 0, function ( $query ) use ( $position ) {
                                     $query->whereHas('occupation_data', function ( $query ) use ( $position ){
                                             $query->where('position_id',$position);
                                       });
                                    })
                                    ->select(['id','name','last_name','dni'])
                                    ->has('dnis')
                                    ->with('dnis:id,employee_id,number,expiration,photo_dni')
                                    ->get();
                    return $pdf = PDF::loadView('Reports.PdfDni', compact('data'))
                                    ->stream('Cédulas.pdf');
                break;
                case 7:/*Domicilios*/
                    $data = Employee::when($department > 0, function ( $query ) use ( $department ) {
                                    $query->whereHas('occupation_data', function ( $query ) use ( $department ){
                                             $query->where('department_type_id',$department);
                                       });
                                    })
                                    ->when($position > 0, function ( $query ) use ( $position ) {
                                     $query->whereHas('occupation_data', function ( $query ) use ( $position ){
                                             $query->where('position_id',$position);
                                       });
                                    })
                                    ->select(['id','name','last_name','dni'])
                                    ->has('address')
                                    ->with('address:id,employee_id,name')
                                    ->get();
                    return $pdf = PDF::loadView('Reports.PdfAddress', compact('data'))
                                    ->stream('Domicilios.pdf');
                break;
                case 8:/*Dependientes*/
                    $data = Employee::when($department > 0, function ( $query ) use ( $department ) {
                                    $query->whereHas('occupation_data', function ( $query ) use ( $department ){
                                             $query->where('department_type_id',$department);
                                       });
                                    })
                                    ->when($position > 0, function ( $query ) use ( $position ) {
                                     $query->whereHas('occupation_data', function ( $query ) use ( $position ){
                                             $query->where('position_id',$position);
                                       });
                                    })
                                    ->select(['id','name','last_name','dni'])
                                    ->has('dependent')
                                    ->with(['dependent:id,employee_id,children_status','dependent.children:id,dependent_id,relationship'])
                                    ->get();
                    return $pdf = PDF::loadView('Reports.PdfDependent', compact('data'))
                                    ->stream('Dependientes.pdf');
                break;
                case 9:/*Departeamentos*/
                    $data = Employee::when($department > 0, function ( $query ) use ( $department ) {
                                    $query->whereHas('occupation_data', function ( $query ) use ( $department ){
                                             $query->where('department_type_id',$department);
                                       });
                                    })
                                    ->when($position > 0, function ( $query ) use ( $position ) {
                                     $query->whereHas('occupation_data', function ( $query ) use ( $position ){
                                             $query->where('position_id',$position);
                                       });
                                    })
                                    ->select(['id','name','last_name','dni'])
                                    ->has('occupation_data')
                                    ->with(['occupation_data:id,employee_id,position_id,department_type_id','occupation_data.department_type:id,name','occupation_data.position:id,name'])
                                    ->get();
                    return $pdf = PDF::loadView('Reports.PdfDepartments', compact('data'))
                                    ->stream('Departamentos.pdf');
                break;
                case 10:/*Salarios */
                    $data = Employee::when($department > 0, function ( $query ) use ( $department ) {
                                    $query->whereHas('occupation_data', function ( $query ) use ( $department ){
                                             $query->where('department_type_id',$department);
                                       });
                                    })
                                    ->when($position > 0, function ( $query ) use ( $position ) {
                                     $query->whereHas('occupation_data', function ( $query ) use ( $position ){
                                             $query->where('position_id',$position);
                                       });
                                    })
                                    ->when($request->has('salaryFrom') && $request->has('salaryUpTo'), function ( $query ) use ( $request ) {
                                     $query->whereHas('salary', function ( $query ) use ( $request ){
                                             $query->where('salary', '>=', $request->salaryFrom)->where('salary', '<=', $request->salaryUpTo);
                                       });
                                    })
                                    ->select(['id','name','last_name','dni'])
                                    ->has('salary')
                                    ->with(['occupation_data:id,employee_id,department_type_id,position_id','occupation_data.department_type:id,name','occupation_data.position:id,name', 'salary:id,employee_id,salary_type_id,salary','salary.salary_type:id,name'])
                                    ->get();
                    return $pdf = PDF::loadView('Reports.PdfSalary', compact('data'))
                                    ->stream('Salarios.pdf');
                break;
                case 11:/*Reporte de acreedores */
                    $data = CreditorsModule::when($department > 0, function ( $query ) use ( $department ) {
                                           $query->whereHas('employee.occupation_data', function ( $query ) use ( $department ){
                                                     $query->where('department_type_id',$department);
                                               });
                                           })
                                           ->when($position > 0, function ( $query ) use ( $position ) {
                                           $query->whereHas('employee.occupation_data', function ( $query ) use ( $position ){
                                                     $query->where('position_id',$position);
                                               });
                                           })
                                           ->when($request->has('type_expense_id'), function ( $query ) use ( $request ) {
                                             $query->whereHas('type_expense', function ( $query ) use ( $request ){
                                                     $query->where('type_expense_id',$request->type_expense_id);
                                               });
                                            })
                                           ->when($request->has('creditor_id'), function ( $query ) use ( $request ) {
                                             $query->whereHas('creditor', function ( $query ) use ( $request ){
                                                     $query->where('creditor_id',$request->creditor_id);
                                               });
                                            })
                                           ->with(['type_expense','employee:id,name,last_name,dni', 'creditor'])
                                           ->has('type_expense')
                                           ->has('employee')
                                           ->get();
                    return $pdf = PDF::loadView('Reports.PdfCreditors', compact('data'))
                                    ->stream('Reporte de acreedores.pdf');
                break;
                case 12:/*Estatus del colaborador*/
                    $data = Employee::when($department > 0, function ( $query ) use ( $department ) {
                                    $query->whereHas('occupation_data', function ( $query ) use ( $department ){
                                             $query->where('department_type_id',$department);
                                       });
                                    })
                                    ->when($position > 0, function ( $query ) use ( $position ) {
                                     $query->whereHas('occupation_data', function ( $query ) use ( $position ){
                                             $query->where('position_id',$position);
                                       });
                                    })
                                    ->when($request->has('contract_type_id'), function ( $query ) use ( $request ) {
                                     $query->whereHas('occupation_data.contract_type', function ( $query ) use ( $request ){
                                             $query->where('contract_type_id',$request->contract_type_id);
                                       });
                                    })
                                    ->when($request->has('status_employee_id'), function ( $query ) use ( $request ) {
                                     $query->whereHas('occupation_data.status_employee', function ( $query ) use ( $request ){
                                             $query->where('status_employee_id',$request->status_employee_id);
                                       });
                                    })
                                    ->select(['id','name','last_name','dni'])
                                    ->has('occupation_data')
                                    ->with('occupation_data:id,employee_id,contract_type_id,status_employee_id,start_contract','occupation_data.contract_type:id,name','occupation_data.status_employee:id,name')
                                    ->get();
                    return $pdf = PDF::loadView('Reports.PdfEmployeeStatus', compact('data'))
                                    ->stream('Estatus del colaborador.pdf');
                break;
                case 13:/*Motivos Terminación laboral*/
                    $data = Employee::when($department > 0, function ( $query ) use ( $department ) {
                                    $query->whereHas('occupation_data', function ( $query ) use ( $department ){
                                             $query->where('department_type_id',$department);
                                       });
                                    })
                                    ->when($position > 0, function ( $query ) use ( $position ) {
                                     $query->whereHas('occupation_data', function ( $query ) use ( $position ){
                                             $query->where('position_id',$position);
                                       });
                                    })
                                    ->when($request->has('contract_termination_id'), function ( $query ) use ( $request ) {
                                     $query->whereHas('occupation_data.contract_termination', function ( $query ) use ( $request ){
                                             $query->where('contract_termination_id',$request->contract_termination_id);
                                       });
                                    })
                                    ->when($request->has('end_contract'), function ( $query ) use ( $request ) {
                                     $query->whereHas('occupation_data', function ( $query ) use ( $request ){
                                             $query->whereDate('end_contract',$request->end_contract);
                                       });
                                    })
                                    ->select(['id','name','last_name','dni'])
                                    ->has('occupation_data.contract_termination')
                                    ->with(['occupation_data:id,employee_id,position_id,department_type_id,contract_termination_id,start_contract,end_contract','occupation_data.department_type:id,name','occupation_data.position:id,name','occupation_data.contract_termination:id,name'])
                                    ->get();
                    return $pdf = PDF::loadView('Reports.PdfReasonsTerminationOfEmployment', compact('data'))
                                    ->stream('Motivos Terminación laboral.pdf');
                break;
                case 14:/*Tipo de cobro*/
                    $data = Employee::when($department > 0, function ( $query ) use ( $department ) {
                                    $query->whereHas('occupation_data', function ( $query ) use ( $department ){
                                             $query->where('department_type_id',$department);
                                       });
                                    })
                                    ->when($position > 0, function ( $query ) use ( $position ) {
                                     $query->whereHas('occupation_data', function ( $query ) use ( $position ){
                                             $query->where('position_id',$position);
                                       });
                                    })
                                    ->when($request->has('payment_method_id'), function ( $query ) use ( $request ) {
                                     $query->whereHas('occupation_data.payment_method', function ( $query ) use ( $request ){
                                             $query->where('payment_method_id',$request->payment_method_id);
                                       });
                                    })
                                    ->select(['id','name','last_name','dni'])
                                    ->has('occupation_data')
                                    ->with(['occupation_data:id,employee_id,position_id,department_type_id,payment_method_id,bank_id,account_number','occupation_data.department_type:id,name','occupation_data.position:id,name','occupation_data.payment_method:id,name','occupation_data.bank:id,name'])
                                    ->get();
                    //Parametro para validar protección de nuero de cuenta
                    $accountProtection = $request->accountProtection;
                    return $pdf = PDF::loadView('Reports.PdfPaymentType', compact('data','accountProtection'))
                                    ->stream('Tipo de cobro.pdf');
                break;
                default:
                    throw new Exception('Filtro no valido', 505);
                break;
            }
        } catch (Exception $e) {
            return response()->json([
                'error' => 'FilteredOutPDFController.FilteredOutPDF.failed',
                'message'=> $e->getMessage()
            ], 505);
        }
    }
}
