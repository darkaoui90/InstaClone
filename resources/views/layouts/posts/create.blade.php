@extends('layouts.app')

@section('content')
<div class="container ig-form-page">
    <div class="ig-form-card">
        <div class="ig-form-head">
            <a href="{{ route('dashboard') }}" class="ig-back-link">&larr; Back to Feed</a>
            <h2>Create a New Post</h2>
            <p>Share a photo and caption with your followers.</p>
        </div>

        <form method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data" class="ig-form">
            @csrf

            <div class="mb-3">
                <label for="caption" class="form-label ig-label">Caption</label>
                <textarea id="caption" class="form-control ig-input @error('caption') is-invalid @enderror" name="caption" rows="4">{{ old('caption') }}</textarea>
                @error('caption')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="image" class="form-label ig-label">Image</label>
                <input type="file" class="form-control ig-input @error('image') is-invalid @enderror" id="image" name="image" required>
                @error('image')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <button type="submit" class="btn ig-btn-primary">Share Post</button>
        </form>
    </div>
</div>
@endsection
