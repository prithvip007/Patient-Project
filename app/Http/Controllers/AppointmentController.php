<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Appointment;
use App\Petient;
use Carbon\Carbon;

class AppointmentController extends Controller
{
    public function getAppointment(){
        $allAppointment = Appointment::all();
        return response()->json(array('data' => $allAppointment));
    }
    public function getPetAppointment($pet_id){
        $allAppointment = Appointment::where('petient_id',$pet_id)->get();
        return response()->json(array('data' => $allAppointment));
    }
    public function getBalance($pet_id){
        $balance = Appointment::where([['petient_id',$pet_id],['fee_paid','0']])->sum('fees');
        return response()->json(array('data' => $balance));
    }
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
    public function getDateAppointment($date){
        $allDateAppointment = Appointment::whereDate('start_time', date('Y-m-d', strtotime($date)))->get();
        return response()->json(array('data' => $allDateAppointment));
    }
    public function getPaidAppointment($paid){
        $allPaidAppointment = Appointment::where('fee_paid', $paid)->get();
        return response()->json(array('data' => $allPaidAppointment));
    }
    public function addAppointment(Request $request){
        $petients = Petient::all();
        if($request->has('_token')){
            $validated = $request->validate([
                'petient_id' => 'required',
                'start_time' => 'required|max:255',
                'end_time' => 'required',
                'desc' => 'required',
                'fees' => 'required|numeric',
                'fee_paid' => 'required',
                'currency' => 'required'
            ]);
            $appointment=new Appointment;  
            $appointment->petient_id=$request->get('petient_id');  
            $appointment->start_time=$request->get('start_time');  
            $appointment->end_time=$request->get('end_time');  
            $appointment->desc=$request->get('desc');  
            $appointment->fees=$request->get('fees');  
            $appointment->fee_paid=$request->get('fee_paid');  
            $appointment->currency=$request->get('currency');  
            $appointment->save();  
            return response()->json('Data is successfully saved');
        }else{
            return view('addAppointment',compact('petients'));
        }
    }
    public function editAppointment($id, Request $request){
        $appointment= Appointment::find($id);
        $petient= Petient::find($appointment->petient_id);
        if($appointment){
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
                return view('editAppointment',compact('appointment','petient'));
            }
        }else{
            return response()->json('Appointment not found');
        }
    }
    public function deleteAppointment($id)
    {
        $appointment= Appointment::find($id)->delete();
        return response()->json('Appointment deleted');
    }
}
