<x-guest-layout>
    @foreach ($posts as $post)
        <p>{{ $post->title }}</p>
        <p>{{ $post->body }}</p>
    @endforeach
</x-guest-layout>