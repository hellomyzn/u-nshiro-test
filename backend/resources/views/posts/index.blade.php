<x-guest-layout>
    @foreach ($posts as $post)
        <a href={{ route('posts.show', $post)}}>
            <p>Title: {{ $post->title }}</p>
        </a>
        <p>Author: {{ $post->user->name }}</p>
        <p>Comment: {{ $post->comments_count }} comments </p>
        <br>
    @endforeach
</x-guest-layout>