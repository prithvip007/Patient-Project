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

/*-----------------patient---------------------*/

// Getting a list of all patients in the hospital :  /patient
Route::get('/patient', 'PatientController@getPatient');

// Adding a new patient :  /addpatient
Route::any('/addpatient', 'PatientController@addPatient')->name('addPatient');

// Update patient details  :  /editpatient/{id}
Route::any('/editpatient/{id}', 'PatientController@editPatient')->name('editPatient');

// Delete patient details :  /deletepatient/{id}
Route::any('/deletepatient/{id}', 'PatientController@deletePatient')->name('deletePatient');

/*-----------------appointment------------------------*/

// getting all appointment : /appointment
Route::get('/appointment', 'AppointmentController@getAppointment');

// Get a list of all appointments for a specific patient. :  /getappointment/{pat_id}
Route::get('/getappointment/{pat_id}', 'AppointmentController@getPatAppointment');

// Get a list of appointments for a specific day. :  /dateappointment/{date}
Route::get('/dateappointment/{date}', 'AppointmentController@getDateAppointment');//dateappointment/18-04-2022

// Get a list of unpaid appointments. :  /paidappointment/{paid}
Route::get('/paidappointment/{paid}', 'AppointmentController@getPaidAppointment');//paidappointment/0

// Adding an appointment to an existing patient :  /addappointment
Route::any('/addappointment', 'AppointmentController@addAppointment')->name('addAppointment');

// Update appointment details. :  /editappointment/{id}
Route::any('/editappointment/{id}', 'AppointmentController@editAppointment')->name('editAppointment');

// Delete appointment details. :  /deleteappointment/{id}
Route::any('/deleteappointment/{id}', 'AppointmentController@deleteAppointment')->name('deleteAppointment');

// Get a remaining bill for a specific patient. :  /getbal/{pat_id}
Route::any('/getbal/{pat_id}', 'AppointmentController@getBalance')->name('getBalance');

// Get the weekly and monthly amount paid, unpaid and balance of hospital in dollars. : /getbalhos/{hsptl_id}/{paid}
Route::any('/getbalhos/{hsptl_id}/{paid}', 'AppointmentController@getHsptlBalance')->name('getHsptlBalance');

// Get the most popular pat type. : /getpopularpat/{hsptl_id}
Route::any('/getpopularpat/{hsptl_id}', 'PatientController@getPopularPat')->name('getPopularPat');

// how much money the hospital makes from each pat type. : /getmoneypat/{hsptl_id}
Route::any('/getmoneypat/{hsptl_id}', 'PatientController@getMoneyFromPat')->name('getMoneyFromPat');


/*-------------------End Thank You----------------*/