@extends('layouts.template')

@section('title', 'Create User')

@section('content')
    <h1>Create User</h1>

    <form method="POST" action="{{ route('persons.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" class="form-control" required pattern="[a-zA-Z\s]+"
                title="Only alphabets and spaces are allowed" value="{{ old('name') }}">
            @error('name')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" class="form-control" required value="{{ old('email') }}">
            @error('email')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="mobile">Mobile No.:</label>
            <input type="tel" name="mobile" id="mobile" class="form-control" required pattern="[0-9]{10}"
                minlength="10" maxlength="10" title="Please enter a 10 digit mobile number" value="{{ old('mobile') }}">
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
            <img id="selected_image" src="#" alt="No Image Selected" style="max-width: 100%; display: none;"
                width="200">
            <script>
                document.getElementById('profile_pic').addEventListener('change', function(event) {
                    var input = event.target;
                    var file = input.files[0];
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        var img = document.getElementById('selected_image');
                        img.src = e.target.result;
                        img.style.display = 'inline-block';
                    };
                    reader.readAsDataURL(file);
                });
            </script>
        </div>

        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" class="form-control" required>
            @error('password')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection
