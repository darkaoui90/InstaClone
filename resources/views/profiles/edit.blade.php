@extends('layouts.app')

@section('content')
<div class="container ig-form-page">
    <div class="ig-form-card">
        <div class="ig-form-head">
            <a href="{{ route('profile.show', $user->id) }}" class="ig-back-link">&larr; Back to Profile</a>
            <h2>Edit Profile</h2>
            <p>Keep your identity and bio up to date.</p>
        </div>

        <form method="POST" action="{{ route('profile.update', $user->id) }}" enctype="multipart/form-data" class="ig-form">
            @csrf
            @method('PATCH')

            <div class="mb-3">
                <label for="name" class="form-label ig-label">Name</label>
                <input id="name" type="text" class="form-control ig-input @error('name') is-invalid @enderror" name="name" value="{{ old('name', $user->name) }}" required>
                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="username" class="form-label ig-label">Username</label>
                <input id="username" type="text" class="form-control ig-input @error('username') is-invalid @enderror" name="username" value="{{ old('username', $user->username) }}" required>
                @error('username')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="bio" class="form-label ig-label">Bio</label>
                <textarea id="bio" class="form-control ig-input @error('bio') is-invalid @enderror" name="bio" rows="4">{{ old('bio', $user->bio) }}</textarea>
                @error('bio')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="profile_image" class="form-label ig-label">Profile Image</label>
                <input id="profile_image" type="file" class="form-control ig-input @error('profile_image') is-invalid @enderror" name="profile_image">
                @error('profile_image')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <button type="submit" class="btn ig-btn-primary">Update Profile</button>
        </form>
    </div>
</div>
@endsection
