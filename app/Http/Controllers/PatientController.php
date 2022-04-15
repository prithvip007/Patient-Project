<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Patient;
use App\Appointment;
use DB;

class PatientController extends Controller
{
    // return all Patients
    public function getPatient(Request $request){
        $allPatient = Patient::all();
        if(!$allPatient->isEmpty()){
            return response()->json(array('data' => $allPatient));
        }else{
            return response()->json(array('data' => 'Patients not found'));
        }
    }

    // return Most Popular Patients of perticular Hospital
    public function getPopularPat($hsptl_id){
        $popularPet = Patient::select(DB::raw("COUNT(id) as cnt"), 'pat_type')
                    ->groupBy('pat_type')
                    ->orderBy('cnt','desc')
                    ->first();
        if($popularPet){
            return response()->json(array('popular pat type' => $popularPet->pat_type));
        }else{
            return response()->json(array('data' => 'pat type not found'));
        }
    }

    // return total money the hospital makes from each pat type
    public function getMoneyFromPat($hsptl_id){
        $allPatient = Patient::join('appointments', 'patients.id', '=', 'appointments.patient_id')
                    ->select('patients.id', 'patients.pat_type','appointments.fees')
                    ->get();
        $totalMoney = array();
        foreach ($allPatient as $patient) {
            if(array_key_exists($patient->pat_type, $totalMoney)){
                $existing_bal = $totalMoney[$patient->pat_type];
                $totalMoney[$patient->pat_type] = $patient->fees+$existing_bal;
            }else{
                $totalMoney[$patient->pat_type] = $patient->fees;
            }
        }
        return response()->json(array('Total money by pat type' => $totalMoney));
    }

    // Add Patient 
    public function addPatient(Request $request){
        if($request->has('_token')){
            $validated = $request->validate([
                'pat_name' => 'required|max:255',
                'pat_type' => 'required',
                'owner_name' => 'required',
                'owner_addr' => 'required',
                'owner_phno' => 'required'
            ]);
            $patient=new Patient;  
            $patient->hospital_id='1';  
            $patient->pat_name=$request->get('pat_name');  
            $patient->pat_type=$request->get('pat_type');  
            $patient->owner_name=$request->get('owner_name');  
            $patient->owner_address=$request->get('owner_addr');  
            $patient->owner_phno=$request->get('owner_phno');  
            $patient->save();  
            return response()->json('Data is successfully saved');
        }else{
            return view('addPatient');
        }
    }

    // Update Patient
    public function editPatient($id, Request $request){
        $patient= Patient::find($id);
        if($patient){
            if($request->has('_token')){
                $validated = $request->validate([
                    'pat_name' => 'required|max:255',
                    'pat_type' => 'required',
                    'owner_name' => 'required',
                    'owner_addr' => 'required',
                    'owner_phno' => 'required'
                ]); 
                $patient->update([
                    'pat_name' => $request->get('pat_name'),
                    'pat_type' => $request->get('pat_type'),
                    'owner_name' => $request->get('owner_name'),
                    'owner_address' => $request->get('owner_addr'),
                    'owner_phno' => $request->get('owner_phno'),
                ]);
                return response()->json('Data is successfully saved');
            }else{
                return view('editPatient',compact('patient'));
            }
        }else{
            return response()->json('Patient not found');
        }
    }

    // delete patient
    public function deletePatient($id)
    {
        $patient= Patient::find($id);
        if($patient){
            $patient->delete();
            return response()->json('Patient deleted');
        }else{
            return response()->json(array('data' => 'Patient not found'));
        }
    }
}
