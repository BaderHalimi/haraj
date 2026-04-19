@foreach($comments as $comment)
    <div class="display-comment" @if($comment->parent_id != null) @endif>
        <strong>{{ $comment->user->name }}</strong>
        <span class="custom-time"> {{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $comment->created_at)->format('Y-m-d  H:i')}}</span>
        <p>{{ $comment->body }}</p>
    </div>
@endforeach  