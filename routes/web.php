<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

//petient
Route::get('/petient', 'PetientController@getPetient');
Route::any('/addpetient', 'PetientController@addPetient')->name('addPetient');
Route::any('/editpetient/{id}', 'PetientController@editPetient')->name('editPetient');
Route::any('/deletepetient/{id}', 'PetientController@deletePetient')->name('deletePetient');

//appointment
Route::get('/appointment', 'AppointmentController@getAppointment');
Route::get('/getappointment/{pet_id}', 'AppointmentController@getPetAppointment');
Route::get('/dateappointment/{date}', 'AppointmentController@getDateAppointment');//dateappointment/18-04-2022
Route::get('/paidappointment/{paid}', 'AppointmentController@getPaidAppointment');//paidappointment/0
Route::any('/addappointment', 'AppointmentController@addAppointment')->name('addAppointment');
Route::any('/editappointment/{id}', 'AppointmentController@editAppointment')->name('editAppointment');
Route::any('/deleteappointment/{id}', 'AppointmentController@deleteAppointment')->name('deleteAppointment');

// get balance
Route::any('/getbal/{pet_id}', 'AppointmentController@getBalance')->name('getBalance');

// get balance hospital
Route::any('/getbalhos/{hsptl_id}/{paid}', 'AppointmentController@getHsptlBalance')->name('getHsptlBalance');

// get most popular pet type
Route::any('/getpopularpet/{hsptl_id}', 'PetientController@getPopularPet')->name('getPopularPet');

// get most popular pet type
Route::any('/getmoneypet/{hsptl_id}', 'PetientController@getMoneyFromPet')->name('getMoneyFromPet');




/*
Adding a new patient :  /addpetient
Getting a list of all patients in the hospital :  /petient
Update patient details  :  /editpetient/{id}
Delete patient details :  /deletepetient/{id}
Adding an appointment to an existing patient :  /addappointment
Get a list of all appointments for a specific patient. :  /getappointment/{pet_id}
Update appointment details. :  /editappointment/{id}
Delete appointment details. :  /deleteappointment/{id}
Get a list of appointments for a specific day. :  /dateappointment/{date}
Get a list of unpaid appointments. :  /paidappointment/{paid}
Get a remaining bill for a specific patient. :  /getbal/{pet_id}
Get the weekly and monthly amount paid, unpaid and balance of hospital in dollars. : /getbalhos/{hsptl_id}/{paid}
Get the most popular pet type, and how much money the hospital makes from each pet type. : /getpopularpet/{hsptl_id}

*/