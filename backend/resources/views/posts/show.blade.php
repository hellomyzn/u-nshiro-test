<p>Title: {{ $post->title }}</p>
<p>Author: {{ $post->user->name }}</p>
<p>Comment: {{ $post->comments_count }} comments </p>
<br>
<br>

<h3>Comments</h3>
@foreach ($post->comments as $comment)
    <p>Name: {{ $comment->name }}</p>
    <p>Body: {{ $comment->body }}</p>
    <br>
    
@endforeach