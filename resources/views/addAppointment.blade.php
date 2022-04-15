
@extends('layout')

@section('content')
	@if ($errors->any())
      <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
        </ul>
      </div><br />
    @endif

	<form method="post" action="{{ route('addAppointment') }}">
		@csrf
		<label>Patient Name</label>
		<select name="patient_id">
			@foreach($patients as $patient)
				<option value="{{ $patient->id }}">{{ $patient->pat_name }}</option>
			@endforeach
		</select><br>
		<label>Appointment Start Time</label>
		<input type="datetime-local" name="start_time" value=""><br>
		<label>Appointment End Time</label>
		<input type="datetime-local" name="end_time" value=""><br>
		<label>Description</label>
		<input type="text" name="desc" value=""><br>
		<label>Total Fees</label>
		<input type="text" name="fees" value=""><br>
		<label>Fee Paid</label>
		<input type="radio" id="fee_paid1" name="fee_paid" value="1">
	  <label for="fee_paid1">Yes</label><br>
	  <input type="radio" id="fee_paid2" name="fee_paid" value="0">
	  <label for="fee_paid2">No</label><br> 
		<label>Currency</label>
		<select name="currency">
			<option value="USD">USD</option>
			<option value="EUR">EUR</option>
			<option value="Bit">Bitcoin</option>
		</select><br>
		<button type="submit">Add Appointment</button>
	</form>
@endsection