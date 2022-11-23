<div class="post-options">
    @isset($user)
        @if($post->canBeLikedByUser($user))
            <x-primary-button onclick="location.href='{{ route('blog.like', $post->slug) }}'">
                {{ __('Like') }}
            </x-primary-button>
        @else
            <x-primary-button onclick="location.href='{{ route('blog.unlike', $post->slug) }}'">
                {{ __('Unlike') }}
            </x-primary-button>
        @endif
        @if($user->id === $post->author_id)
            <x-primary-button onclick="location.href='{{ route('blog.edit', $post->slug) }}'">
                {{ __('Edit') }}
            </x-primary-button>

            <x-primary-button onclick="location.href='{{ route('blog.delete', $post->slug) }}'">
                {{ __('Delete') }}
            </x-primary-button>
        @endif
    @endisset
    <x-primary-button onclick="location.href='{{ route('index') }}'">
        {{ __('Back') }}
    </x-primary-button>
</div>
