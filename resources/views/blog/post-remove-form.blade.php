<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Delete a post') }}
        </h2>
    </x-slot>

    <x-slot name="slot">
        @if(!$post)
            <p class="notification">{{ __('Post was not found, pretend that you already deleted it.') }}</p>
        @else
            {{ $post->title  }}
            <form method="POST" action="{{ route('blog.handleDelete', $post->slug) }}">
                @csrf
                <p class="notification">{{ __('Delete this post, really? This is a point of no return.') }}</p>
                    <x-primary-button class="ml-4 right">
                        {{ __('Delete') }}
                    </x-primary-button>
                </div>
            </form>
            <x-primary-button class="back-button" onclick="location.href='{{ route('index') }}'">
                {{ __('Back') }}
            </x-primary-button>
        @endif
    </x-slot>

</x-app-layout>
