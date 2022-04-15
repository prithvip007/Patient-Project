
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
	<form method="post" action="{{ route('editPatient', ['id' => $patient->id]) }}">
		@csrf
		<label>Patient Name</label>
		<input type="text" name="pat_name" value="{{ $patient->pat_name }}"><br>
		<label>Patient Type</label>
		<select name="pat_type">
			@if($patient->pat_type=='cat') <option value="cat" selected >Cat</option> @else <option value="cat">Cat</option> @endif
			@if($patient->pat_type=='dog') <option value="dog" selected >Dog</option> @else <option value="dog">Dog</option> @endif
			@if($patient->pat_type=='bird') <option value="bird" selected >Bird</option> @else <option value="bird">Bird</option> @endif
		</select><br>
		<label>Owner Name</label>
		<input type="text" name="owner_name" value="{{ $patient->owner_name }}"><br>
		<label>Owner Address</label>
		<input type="text" name="owner_addr" value="{{ $patient->owner_address }}"><br>
		<label>Owner Phone</label>
		<input type="text" name="owner_phno" value="{{ $patient->owner_phno }}"><br>
		<button type="submit">Update Patient</button>
	</form>
@endsection