@extends('layouts.template')

@section('title', 'Edit User')

@section('content')
    <h1>Edit User</h1>

    <form method="POST" action="{{ route('persons.update', $person->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ $person->name }}" required
                pattern="[a-zA-Z\s]+" title="Only alphabets and spaces are allowed">
            @error('name')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ $person->email }}" required>
            @error('email')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="mobile">Mobile No.:</label>
            <input type="tel" name="mobile" id="mobile" class="form-control" value="{{ $person->mobile }}" required
                pattern="[0-9]{10}" minlength="10" maxlength="10" title="Please enter a 10 digit mobile number">
            @error('mobile')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="profile_pic">Profile Picture:</label>
            <input type="file" name="profile_pic" id="profile_pic" class="form-control-file"
                accept="image/png, image/jpeg">
            @error('profile_pic')
                <div class="text-danger">{{ $message }}</div>
            @enderror
            <br>
            <img src="{{ asset('profile_pics/' . $person->profile_pic) }}" alt="Profile Picture" width="200">
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
    </form>
@endsection
