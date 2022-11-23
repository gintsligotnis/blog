@if ($post)
    <div class="post-single">
        <h1>{{ $post->title }} </h1>
        <span class="date">{{ $post->created_at }}</span>
        <span class="likes">{{ $post->likes()->count() }} <x-heroicon-s-heart class="h-6 w-6 text-red-600" /></span>
        <p>{{ $post->content }}</p>
    </div>

    @includeIf('blog.post-actions')
@else
    <p>{{ __('Post was not found, sorry!') }}</p>
@endif
