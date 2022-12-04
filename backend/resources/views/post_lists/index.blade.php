<x-guest-layout>
    @foreach ($posts as $post)
        <p>Title: {{ $post->title }}</p>
        <p>Author: {{ $post->user->name }}</p>
        <br>
    @endforeach
</x-guest-layout>