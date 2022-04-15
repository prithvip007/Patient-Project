
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
	<form method="post" action="{{ route('editAppointment', ['id' => $appointment->id]) }}">
		@csrf
		<label>Petient Name : {{ $petient->pet_name }}</label><br>
		<label>Appointment Start Time</label>
		<input type="datetime-local" name="start_time" value="{{ date ('Y-m-d\TH:i:s', strtotime($appointment->start_time)) }}"><br>
		<label>Appointment End Time</label>
		<input type="datetime-local" name="end_time" value="{{ date ('Y-m-d\TH:i:s', strtotime($appointment->end_time)) }}"><br>
		<label>Description</label>
		<input type="text" name="desc" value="{{ $appointment->desc }}"><br>
		<label>Total Fees</label>
		<input type="text" name="fees" value="{{ $appointment->fees }}"><br>
		<label>Fee Paid</label>
		@if($appointment->fee_paid=='1') <input type="radio" id="fee_paid1" name="fee_paid" value="1" checked>@else<input type="radio" id="fee_paid1" name="fee_paid" value="1">@endif
	  <label for="fee_paid1">Yes</label><br>
	  @if($appointment->fee_paid=='0') <input type="radio" id="fee_paid2" name="fee_paid" value="0" checked>@else<input type="radio" id="fee_paid2" name="fee_paid" value="0">@endif
	  <label for="fee_paid2">No</label><br> 
		<label>Currency</label>
		<select name="currency">
			@if($appointment->currency=='USD') <option value="USD" selected >USD</option> @else <option value="USD">USD</option> @endif
			@if($appointment->currency=='EUR') <option value="EUR" selected >EUR</option> @else <option value="EUR">EUR</option> @endif
			@if($appointment->currency=='Bit') <option value="Bit" selected >Bitcoin</option> @else <option value="Bit">Bitcoin</option> @endif
		</select><br>
		<button type="submit">Update Appointment</button>
	</form>
@endsection