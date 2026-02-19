@extends('layouts.app')

@section('content')
<div class="container ig-profile-page">
    <section class="ig-profile-header">
        <img src="{{ $user->profile_image ? asset('storage/' . $user->profile_image) : 'https://via.placeholder.com/160' }}" class="ig-profile-avatar" alt="profile image">

        <div class="ig-profile-meta">
            <div class="ig-profile-top">
                <h1>{{ '@' . ($user->username ?? $user->name) }}</h1>
                @if(auth()->id() === $user->id)
                    <div class="ig-profile-actions">
                        <a href="{{ route('profile.edit', $user->id) }}" class="btn ig-outline-btn">Edit Profile</a>
                        <a href="{{ route('posts.create') }}" class="btn ig-btn-primary">Create Post</a>
                    </div>
                @endif
            </div>

            <div class="ig-profile-stats">
                <span><strong>{{ $stats['posts'] }}</strong> posts</span>
                <span><strong>{{ $stats['likes'] }}</strong> likes</span>
                <span><strong>{{ $stats['comments'] }}</strong> comments</span>
            </div>

            <p class="ig-profile-name">{{ $user->name }}</p>
            @if($user->bio)
                <p class="ig-profile-bio">{{ $user->bio }}</p>
            @endif
        </div>
    </section>

    <section class="ig-profile-posts">
        <h2>Posts</h2>
        <div class="ig-profile-grid">
            @forelse($user->posts as $post)
                <a href="{{ route('posts.show', $post->id) }}" class="ig-grid-item">
                    <img src="{{ asset('storage/' . $post->image_path) }}" alt="post image">
                    <div class="ig-grid-overlay">
                        <span>{{ $post->likes_count }} likes</span>
                        <span>{{ $post->comments_count }} comments</span>
                    </div>
                </a>
            @empty
                <div class="ig-empty-state">
                    <h3>No posts yet</h3>
                    <p>When posts are shared, they will appear here.</p>
                    @if(auth()->id() === $user->id)
                        <a href="{{ route('posts.create') }}" class="btn ig-btn-primary">Create First Post</a>
                    @endif
                </div>
            @endforelse
        </div>
    </section>
</div>
@endsection
