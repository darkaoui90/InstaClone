@extends('layouts.app')

@section('content')
<div class="container ig-feed-page">
    <div class="ig-feed-toolbar">
        <h2 class="ig-page-title">Feed</h2>
        <a href="{{ route('posts.create') }}" class="btn ig-btn-primary">Create Post</a>
    </div>

    <div class="ig-feed-list">
        @forelse($posts as $post)
            @php
                $likedByMe = $post->likes->contains('user_id', auth()->id());
            @endphp
            <article class="ig-post-card">
                <header class="ig-post-head">
                    <a href="{{ $post->user ? route('profile.show', $post->user->id) : '#' }}" class="ig-user">
                        <img src="{{ $post->user && $post->user->profile_image ? asset('storage/' . $post->user->profile_image) : 'https://via.placeholder.com/40' }}" class="ig-avatar" alt="avatar">
                        <span>{{ $post->user ? ($post->user->username ?? $post->user->name) : 'Deleted User' }}</span>
                    </a>
                    <a href="{{ route('posts.show', $post->id) }}" class="ig-more-link">Open</a>
                </header>

                <a href="{{ route('posts.show', $post->id) }}" class="ig-post-image-wrap">
                    <img src="{{ asset('storage/' . $post->image_path) }}" class="ig-post-image" alt="post image">
                </a>

                <div class="ig-post-body">
                    <div class="ig-post-actions">
                        @if($likedByMe)
                            <form action="{{ route('likes.destroy', $post->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="ig-icon-btn" aria-label="Unlike">
                                    <svg viewBox="0 0 24 24" class="ig-icon ig-heart-filled" aria-hidden="true">
                                        <path d="M12 21s-7-4.35-9.5-8.28C.3 9.2 2.1 5 6 5c2.2 0 3.4 1.3 4 2.2C10.6 6.3 11.8 5 14 5c3.9 0 5.7 4.2 3.5 7.72C19 16.65 12 21 12 21z"/>
                                    </svg>
                                </button>
                            </form>
                        @else
                            <form action="{{ route('likes.store', $post->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="ig-icon-btn" aria-label="Like">
                                    <svg viewBox="0 0 24 24" class="ig-icon" aria-hidden="true">
                                        <path d="M12 21s-7-4.35-9.5-8.28C.3 9.2 2.1 5 6 5c2.2 0 3.4 1.3 4 2.2C10.6 6.3 11.8 5 14 5c3.9 0 5.7 4.2 3.5 7.72C19 16.65 12 21 12 21z" fill="none" stroke="currentColor" stroke-width="1.7"/>
                                    </svg>
                                </button>
                            </form>
                        @endif

                        <a href="{{ route('posts.show', $post->id) }}" class="ig-icon-btn" aria-label="Comment">
                            <svg viewBox="0 0 24 24" class="ig-icon" aria-hidden="true">
                                <path d="M4 5.5A2.5 2.5 0 0 1 6.5 3h11A2.5 2.5 0 0 1 20 5.5v8a2.5 2.5 0 0 1-2.5 2.5H11l-4.5 4v-4H6.5A2.5 2.5 0 0 1 4 13.5v-8z" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round"/>
                            </svg>
                        </a>
                    </div>

                    <p class="ig-post-likes">{{ $post->likes->count() }} likes</p>
                    <p class="ig-post-caption">
                        @if($post->user)
                            <a href="{{ route('profile.show', $post->user->id) }}" class="ig-user-link">{{ $post->user->username ?? $post->user->name }}</a>
                        @endif
                        <span>{{ $post->caption }}</span>
                    </p>
                    <a href="{{ route('posts.show', $post->id) }}" class="ig-post-comments-link">
                        View all {{ $post->comments->count() }} comments
                    </a>
                    <p class="ig-post-time">{{ $post->created_at->diffForHumans() }}</p>
                </div>
            </article>
        @empty
            <div class="ig-empty-state">
                <h3>No posts yet</h3>
                <p>Create your first post and it will appear in your feed.</p>
                <a href="{{ route('posts.create') }}" class="btn ig-btn-primary">Create Post</a>
            </div>
        @endforelse
    </div>
</div>
@endsection
