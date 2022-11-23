@auth
    <x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Blog') }}
            </h2>
        </x-slot>

        <x-slot name="slot">
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        @includeIf('blog.list')
                    </div>

                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        @if (isset($user))
                            <x-primary-button onclick="location.href='{{ route('blog.create') }}'">
                                {{ __('Post something') }}
                            </x-primary-button>
                        @endif
                    </div>
                </div>
            </div>
        </x-slot>
    </x-app-layout>
@endauth

@guest
    <x-blog-guest-layout>

        <x-slot name="slot">
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        @includeIf('blog.list')
                    </div>
                </div>
            </div>
        </x-slot>
    </x-blog-guest-layout>
@endguest
