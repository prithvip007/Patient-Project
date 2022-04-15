
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

	<form method="post" action="{{ route('addPetient') }}">
		@csrf
		<label>Petient Name</label>
		<input type="text" name="pet_name" value=""><br>
		<label>Petient Type</label>
		<select name="pet_type">
			<option value="cat">Cat</option>
			<option value="dog">Dog</option>
			<option value="bird">Bird</option>
		</select><br>
		<label>Owner Name</label>
		<input type="text" name="owner_name" value=""><br>
		<label>Owner Address</label>
		<input type="text" name="owner_addr" value=""><br>
		<label>Owner Phone</label>
		<input type="text" name="owner_phno" value=""><br>
		<button type="submit">Add Petient</button>
	</form>
@endsection