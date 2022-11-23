<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Write something interesting') }}
        </h2>
    </x-slot>

    <x-slot name="slot">
        @if($action == 'edit' && !isset($post))
            <p class="notification">{{ __('Post was not found, strange isnt it.') }}</p>
        @else
            <form method="POST" action=" @if($action == 'add'){{ route('blog.handleCreate') }} @else {{ route('blog.handelEdit', $post->slug) }} @endif">
                @csrf

                <!-- Name -->
                <div>
                    <x-input-label for="title" :value="__('Title')" />

                    <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title') ?? (isset($post) ? $post->title : '')" required autofocus />

                    <x-input-error :messages="$errors->get('title')" class="mt-2" />
                </div>

                <!-- Content -->
                <div>
                    <x-input-label for="content" :value="__('Content')" />

                    <textarea rows="5" id="content" class="block mt-1 w-full" name="content" required autofocus >{{ old('content') ?? (isset($post) ? $post->content: '') }}</textarea>

                    <x-input-error :messages="$errors->get('content')" class="mt-2" />
                </div>

                <div class="flex items-center justify-end mt-4">

                    <div>
                        <x-checkbox name="published" id="published" value="1" checked="old('published')" :label="__('Save as draft')"/>
                    </div>

                    <x-primary-button class="ml-4">
                        {{ __('Submit') }}
                    </x-primary-button>
                </div>
            </form>
            <x-primary-button onclick="location.href='{{ route('index') }}'">
                {{ __('Back') }}
            </x-primary-button>
        @endif
    </x-slot>

</x-app-layout>
