@if(session('statusMessage'))
    <p class="notification">{{ session('statusMessage') }}</p>
@endif

@forelse ($posts as $post)
    <div class="post-list">
        <a class="post-title" href="{{ route('blog.view', $post->slug) }}">{{ $post->title }}</a>
        @if(!$post->published) <span class="status">{{ __('(Draft)') }}</span> @endif

        <span class="date">{{ $post->created_at }}</span>
        <span class="likes">{{ $post->likes()->count() }} <x-heroicon-s-heart class="h-6 w-6 text-red-600" /></span>
    </div>
@empty
    <p>{{ __('No one posted so far, You can be the first') }}</p>
@endforelse


