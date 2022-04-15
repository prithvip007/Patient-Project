<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Appointment;
use App\Patient;
use Carbon\Carbon;

class AppointmentController extends Controller
{
    // return All Appointments
    public function getAppointment(){
        $allAppointment = Appointment::all();
        if(!$allAppointment->isEmpty()){
            return response()->json(array('data' => $allAppointment));
        }else{
            return response()->json(array('data' => 'Appointment not found'));
        }
    }
    // return Appointments of Perticular Patient
    public function getPatAppointment($pat_id){
        $allAppointment = Appointment::where('patient_id',$pat_id)->get();
        if(!$allAppointment->isEmpty()){
            return response()->json(array('data' => $allAppointment));
        }else{
            return response()->json(array('data' => 'Appointment not found'));
        }
    }

    // return Panding Balance of Perticular Patient
    public function getBalance($pat_id){
        $balance = Appointment::where([['patient_id',$pat_id],['fee_paid','0']])->sum('fees');
        
        return response()->json(array('data' => $balance));
        
    }

    // return Panding/collected Total Balance, Weekly, monthly Balance of Perticular Hospital
    public function getHsptlBalance($hsptl_id,$paid){
        //for current week
        $weekAmount = Appointment::whereBetween('start_time', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->where([['hospital_id',$hsptl_id],['fee_paid',$paid]])->get();
        //for current month
        $monthAmount = Appointment::whereMonth('start_time', date('m'))->whereYear('start_time', date('Y'))->where([['hospital_id',$hsptl_id],['fee_paid',$paid]])->get();
        $totalBalance = Appointment::where([['hospital_id',$hsptl_id]])->sum('fees');

        return response()->json(array('totalBalance' => $totalBalance,
                                    'current week bal' => $weekAmount,
                                    'current month bal' => $monthAmount,
                                ));
    }

    // return Appointments of Perticular Date
    public function getDateAppointment($date){
        $allDateAppointment = Appointment::whereDate('start_time', date('Y-m-d', strtotime($date)))->get();
        if(!$allDateAppointment->isEmpty()){
            return response()->json(array('data' => $allDateAppointment));
        }else{
            return response()->json(array('data' => 'Appointment not found on this date'));
        }
        
    }

    // return unpaid/paid Appointments
    public function getPaidAppointment($paid){
        $allPaidAppointment = Appointment::where('fee_paid', $paid)->get();
        
        if(!$allPaidAppointment->isEmpty()){
            return response()->json(array('data' => $allPaidAppointment));
        }else{
            return response()->json(array('data' => 'Appointment not found'));
        }
    }

    // Add New Appointment
    public function addAppointment(Request $request){
        $patients = Patient::all();
        if($request->has('_token')){
            $validated = $request->validate([
                'patient_id' => 'required',
                'start_time' => 'required|max:255',
                'end_time' => 'required',
                'desc' => 'required',
                'fees' => 'required|numeric',
                'fee_paid' => 'required',
                'currency' => 'required'
            ]);
            $appointment=new Appointment;  
            $appointment->hospital_id='1';  
            $appointment->patient_id=$request->get('patient_id');  
            $appointment->start_time=$request->get('start_time');  
            $appointment->end_time=$request->get('end_time');  
            $appointment->desc=$request->get('desc');  
            $appointment->fees=$request->get('fees');  
            $appointment->fee_paid=$request->get('fee_paid');  
            $appointment->currency=$request->get('currency');  
            $appointment->save();  
            return response()->json('Data is successfully saved');
        }else{
            return view('addAppointment',compact('patients'));
        }
    }

    // update single Perticular Appointment
    public function editAppointment($id, Request $request){
        $appointment= Appointment::find($id);
        if($appointment){
            $patient= Patient::find($appointment->patient_id);
            if($request->has('_token')){
                $validated = $request->validate([
                    'start_time' => 'required|max:255',
                    'end_time' => 'required',
                    'desc' => 'required',
                    'fees' => 'required|numeric',
                    'fee_paid' => 'required',
                    'currency' => 'required'
                ]); 
                $appointment->update([
                    'start_time' => $request->get('start_time'),
                    'end_time' => $request->get('end_time'),
                    'desc' => $request->get('desc'),
                    'fees' => $request->get('fees'),
                    'fee_paid' => $request->get('fee_paid'),
                    'currency' => $request->get('currency'),
                ]);
                return response()->json('Data is successfully saved');
            }else{
                return view('editAppointment',compact('appointment','patient'));
            }
        }else{
            return response()->json('Appointment not found');
        }
    }

    // Delete Appointment with id
    public function deleteAppointment($id)
    {
        $appointment= Appointment::find($id);
        if($appointment){
            $appointment->delete();
            return response()->json('Appointment deleted');
        }else{
            return response()->json(array('data' => 'Appointment not found'));
        }
    }
}
