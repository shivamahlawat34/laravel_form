@extends('layouts.template')

@section('title', 'User List')

@section('content')
    <h1>User List</h1>

    <div class="d-flex justify-content-between mb-3">
        <div></div>
        <div>
            <a href="{{ route('export-persons') }}" class="btn btn-success">Export CSV</a>
        </div>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Mobile No.</th>
                <th>Profile Pic</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($persons as $person)
                <tr>
                    <td>{{ $person->name }}</td>
                    <td>{{ $person->email }}</td>
                    <td>{{ $person->mobile }}</td>
                    <td>
                        @if ($person->profile_pic)
                            <img src="{{ asset('profile_pics/' . $person->profile_pic) }}" alt="Profile Picture"
                                style="max-width: 100px;">
                        @else
                            No Picture
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('persons.edit', $person->id) }}" class="btn btn-primary">Edit</a>
                        <form action="{{ route('persons.destroy', $person->id) }}" method="POST"
                            style="display: inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
