
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
	<form method="post" action="{{ route('editPetient', ['id' => $petient->id]) }}">
		@csrf
		<label>Petient Name</label>
		<input type="text" name="pet_name" value="{{ $petient->pet_name }}"><br>
		<label>Petient Type</label>
		<select name="pet_type">
			@if($petient->pet_type=='cat') <option value="cat" selected >Cat</option> @else <option value="cat">Cat</option> @endif
			@if($petient->pet_type=='dog') <option value="dog" selected >Dog</option> @else <option value="dog">Dog</option> @endif
			@if($petient->pet_type=='bird') <option value="bird" selected >Bird</option> @else <option value="bird">Bird</option> @endif
		</select><br>
		<label>Owner Name</label>
		<input type="text" name="owner_name" value="{{ $petient->owner_name }}"><br>
		<label>Owner Address</label>
		<input type="text" name="owner_addr" value="{{ $petient->owner_address }}"><br>
		<label>Owner Phone</label>
		<input type="text" name="owner_phno" value="{{ $petient->owner_phno }}"><br>
		<button type="submit">Add Petient</button>
	</form>
@endsection