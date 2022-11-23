@auth
    <x-app-layout >

        <x-slot name="slot">
            @includeIf('blog.post-single')
        </x-slot>

    </x-app-layout>
@endauth

@guest
    <x-blog-guest-layout >
        <x-slot name="slot">
            @includeIf('blog.post-single')
        </x-slot>

    </x-blog-guest-layout>
@endguest
