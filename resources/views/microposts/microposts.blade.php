<ul class="media-list">
    @foreach ($microposts as $micropost)
        <li class="media mb-3">
            @if ($micropost->image_file_name == "0")
                <img class="media-object rounded" src="{{ Gravatar::src($micropost->user->email, 100) }}"alt="">
            @else
                <img src="/item/{{ $micropost->image_file_name }}" width="100" height="100"> 
            @endif
            <div class="media-body ml-3">
                <div>
                    {!! link_to_route('users.show', $micropost->user->name, ['id' => $micropost->user->id]) !!} <span class="text-muted">posted at {{ $micropost->created_at }}</span>
                </div>
                <div>
                    <p>{!! nl2br(e($micropost->content)) !!}</p>
                <div class="btn-group">
                    @include('user_favorite.favorite_button',['micropost' => $micropost])

                    @if (Auth::id() == $micropost->user_id)
                        {!! Form::open(['route' => ['microposts.destroy', $micropost->id], 'method' => 'delete']) !!}
                            {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-sm']) !!}
                        {!! Form::close() !!}
                    @endif
                </div>
            </div>
        </li>
    @endforeach
</ul>
{{ $microposts->render('pagination::bootstrap-4') }}