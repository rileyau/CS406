@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Your Posts</div>

                <div class="panel-body">
                    @if(count($posts) > 0)
                        @foreach($posts as $post)
                                <div class='well well-sm'>
                                    <a href='/b/{{$post->board}}/posts/{{$post->id}}'>{{$post->title}}</a> in {{$post->board}} at {{$post->created_at}}
                                </div>
                        @endforeach

                        {{$posts->links()}}
                    @else
                        <p>You have no posts yet</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
