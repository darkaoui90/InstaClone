@extends('layouts.app')

@section('content')
<div class="container ig-post-detail-page">
    <a href="{{ route('dashboard') }}" class="ig-back-link">&larr; Back to Feed</a>

    <div class="ig-post-detail">
        <div class="ig-post-detail-media">
            <img src="{{ asset('storage/' . $post->image_path) }}" class="ig-detail-image" alt="post image">
        </div>

        <div class="ig-post-detail-side">
            <header class="ig-post-head ig-post-head-detail">
                @if($post->user)
                    <a href="{{ route('profile.show', $post->user->id) }}" class="ig-user">
                        <img src="{{ $post->user->profile_image ? asset('storage/' . $post->user->profile_image) : 'https://via.placeholder.com/40' }}" class="ig-avatar" alt="avatar">
                        <span>{{ $post->user->username ?? $post->user->name }}</span>
                    </a>
                @else
                    <span class="ig-user">Deleted User</span>
                @endif

                @if(auth()->id() === $post->user_id)
                    <div class="ig-owner-actions">
                        <a href="{{ route('posts.edit', $post->id) }}" class="ig-inline-link">Edit</a>
                        <form action="{{ route('posts.destroy', $post->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="ig-inline-link ig-inline-danger">Delete</button>
                        </form>
                    </div>
                @endif
            </header>

            <div class="ig-detail-caption">
                @if($post->user)
                    <a href="{{ route('profile.show', $post->user->id) }}" class="ig-user-link">{{ $post->user->username ?? $post->user->name }}</a>
                @endif
                <span>{{ $post->caption }}</span>
            </div>

            <div class="ig-comments-box">
                @forelse($post->comments as $comment)
                    <div class="ig-comment-row">
                        <p class="ig-comment-text">
                            <strong>{{ $comment->user ? ($comment->user->username ?? $comment->user->name) : 'Deleted User' }}</strong>
                            <span>{{ $comment->comment }}</span>
                        </p>

                        @if(auth()->id() === $comment->user_id || auth()->id() === $post->user_id)
                            <form action="{{ route('comments.destroy', $comment->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="ig-delete-comment" aria-label="Delete comment">&times;</button>
                            </form>
                        @endif
                    </div>
                @empty
                    <p class="ig-empty-comments">No comments yet. Start the conversation.</p>
                @endforelse
            </div>

            @php
                $likedByMe = $post->likes->contains('user_id', auth()->id());
            @endphp
            <div class="ig-post-actions ig-detail-actions">
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
            </div>

            <p class="ig-post-likes">{{ $post->likes->count() }} likes</p>
            <p class="ig-post-time">{{ $post->created_at->format('F d, Y') }}</p>

            <form action="{{ route('comments.store', $post->id) }}" method="POST" class="ig-comment-form">
                @csrf
                <input type="text" name="comment" class="form-control ig-input" placeholder="Add a comment..." required>
                <button class="btn ig-btn-primary" type="submit">Post</button>
            </form>
        </div>
    </div>
</div>
@endsection
