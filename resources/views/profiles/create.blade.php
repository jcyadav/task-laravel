@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Create Profile</h2>
    <form method="POST" action="{{ route('profiles.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="profile_image" class="form-label">Profile Image (JPG only)</label>
            <input type="file" class="form-control @error('profile_image') is-invalid @enderror" id="profile_image" name="profile_image" accept=".jpg">
            @error('profile_image')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="name" class="form-label">Name (Max 25 characters)</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" maxlength="25" value="{{ old('name', isset($profile) ? $profile->name : '') }}">
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="phone" class="form-label">Phone (+1-(XXX) XXX-XXXX)</label>
            <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" pattern="\+1-\(\d{3}\) \d{3}-\d{4}" value="{{ old('phone', isset($profile) ? $profile->phone : '') }}">
            @error('phone')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', isset($profile) ? $profile->email : '') }}">
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="street_address" class="form-label">Street Address</label>
            <input type="text" class="form-control @error('street_address') is-invalid @enderror" id="street_address" name="street_address" value="{{ old('street_address', isset($profile) ? $profile->street_address : '') }}">
            @error('street_address')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="city" class="form-label">City</label>
            <input type="text" class="form-control @error('city') is-invalid @enderror" id="city" name="city" value="{{ old('city', isset($profile) ? $profile->city : '') }}">
            @error('city')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="state" class="form-label">State</label>
            <select class="form-select @error('state') is-invalid @enderror" id="state" name="state">
            <option value="">Select State</option>
                <option value="CA" {{ old('state', isset($profile) ? $profile->state : '') == 'CA' ? 'selected' : '' }}>CA</option>
                <option value="NY" {{ old('state', isset($profile) ? $profile->state : '') == 'NY' ? 'selected' : '' }}>NY</option>
                <option value="AT" {{ old('state', isset($profile) ? $profile->state : '') == 'AT' ? 'selected' : '' }}>AT</option>
            </select>
            @error('state')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="country" class="form-label">Country</label>
            <select class="form-select @error('country') is-invalid @enderror" id="country" name="country">
            <option value="">Select Country</option>
                <option value="IN" {{ old('country', isset($profile) ? $profile->country : '') == 'IN' ? 'selected' : '' }}>IN</option>
                <option value="US" {{ old('country', isset($profile) ? $profile->country : '') == 'US' ? 'selected' : '' }}>US</option>
                <option value="EU" {{ old('country', isset($profile) ? $profile->country : '') == 'EU' ? 'selected' : '' }}>EU</option>
            </select>
            @error('country')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">{{ isset($profile) ? 'Update' : 'Create' }}</button>
    </form>
</div>
@endsection