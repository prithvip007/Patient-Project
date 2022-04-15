<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Petient;
use App\Appointment;
use DB;

class PetientController extends Controller
{
    public function getPetient(Request $request){
        $allPetient = Petient::all();
        return response()->json(array('data' => $allPetient));
    }
    public function getPopularPet($hsptl_id){
        $allPetient = Petient::select(DB::raw("COUNT(id) as cnt"), 'pet_type')
                    ->groupBy('pet_type')
                    ->orderBy('cnt','desc')
                    ->first();
        return response()->json(array('popular pet type' => $allPetient->pet_type));
    }
    public function getMoneyFromPet($hsptl_id){
        $allPetient = Petient::join('appointments', 'patients.id', '=', 'appointments.petient_id')
                    ->select('patients.id', 'patients.pet_type','appointments.fees')
                    ->get();
        $totalMoney = array();
        foreach ($allPetient as $petient) {
            if(array_key_exists($petient->pet_type, $totalMoney)){
                $existing_bal = $totalMoney[$petient->pet_type];
                $totalMoney[$petient->pet_type] = $petient->fees+$existing_bal;
            }else{
                $totalMoney[$petient->pet_type] = $petient->fees;
            }
        }
        return response()->json(array('Total money by pet type' => $totalMoney));
    }
    public function addPetient(Request $request){
        if($request->has('_token')){
            $validated = $request->validate([
                'pet_name' => 'required|max:255',
                'pet_type' => 'required',
                'owner_name' => 'required',
                'owner_addr' => 'required',
                'owner_phno' => 'required'
            ]);
            $petient=new Petient;  
            $petient->pet_name=$request->get('pet_name');  
            $petient->pet_type=$request->get('pet_type');  
            $petient->owner_name=$request->get('owner_name');  
            $petient->owner_address=$request->get('owner_addr');  
            $petient->owner_phno=$request->get('owner_phno');  
            $petient->save();  
            return response()->json('Data is successfully saved');
        }else{
            return view('addPetient');
        }
    }
    public function editPetient($id, Request $request){
        $petient= Petient::find($id);
        if($petient){
            if($request->has('_token')){
                $validated = $request->validate([
                    'pet_name' => 'required|max:255',
                    'pet_type' => 'required',
                    'owner_name' => 'required',
                    'owner_addr' => 'required',
                    'owner_phno' => 'required'
                ]); 
                $petient->update([
                    'pet_name' => $request->get('pet_name'),
                    'pet_type' => $request->get('pet_type'),
                    'owner_name' => $request->get('owner_name'),
                    'owner_address' => $request->get('owner_addr'),
                    'owner_phno' => $request->get('owner_phno'),
                ]);
                return response()->json('Data is successfully saved');
            }else{
                return view('editPetient',compact('petient'));
            }
        }else{
            return response()->json('Petient not found');
        }
    }
    public function deletePetient($id)
    {
        $petient= Petient::find($id)->delete();
        return response()->json('Petient deleted');
    }
}
