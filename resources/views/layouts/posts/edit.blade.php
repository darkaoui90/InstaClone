@extends('layouts.app')

@section('content')
<div class="container ig-form-page">
    <div class="ig-form-card">
        <div class="ig-form-head">
            <a href="{{ route('dashboard') }}" class="ig-back-link">&larr; Back to Feed</a>
            <h2>Edit Post</h2>
            <p>Update your caption to keep your post fresh.</p>
        </div>

        <form method="POST" action="{{ route('posts.update', $post->id) }}" class="ig-form">
            @csrf
            @method('PATCH')

            <div class="mb-4">
                <label for="caption" class="form-label ig-label">Caption</label>
                <textarea id="caption" class="form-control ig-input @error('caption') is-invalid @enderror" name="caption" rows="4">{{ old('caption', $post->caption) }}</textarea>
                @error('caption')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <button type="submit" class="btn ig-btn-primary">Update Post</button>
        </form>
    </div>
</div>
@endsection
