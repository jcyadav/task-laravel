@extends('layouts.app')

@section('content')
<div class="container">
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <h2 class="mb-4">Task Yes IT Labs</h2>

    <a href="{{ route('profiles.create') }}" class="btn btn-success mb-3">Create New Profile</a>

<form action="{{ route('profiles.import') }}" method="POST" enctype="multipart/form-data" class="mb-3">
    @csrf
    <div class="input-group">
        <input type="file" class="form-control" name="csv_file" accept=".csv" required>
        <button type="submit" class="btn btn-info">Import CSV</button>
    </div>
</form>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Profile Image</th>
                <th>Name</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Street Address</th>
                <th>City</th>
                <th>State</th>
                <th>Country</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($profiles as $profile)
                <tr>
                    <td><img src="{{ asset($profile->profile_image) }}" alt="Profile Image" width="100" height="100"></td>
                    <td>{{ $profile->name }}</td>
                    <td>{{ $profile->phone }}</td>
                    <td>{{ $profile->email }}</td>
                    <td>{{ $profile->street_address }}</td>
                    <td>{{ $profile->city }}</td>
                    <td>{{ $profile->state }}</td>
                    <td>{{ $profile->country }}</td>
                    <td>
                        <a href="{{ route('profiles.edit', $profile->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('profiles.destroy', $profile->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection