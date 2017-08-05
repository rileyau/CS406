@extends('layouts.app')

@section('content')
@include('inc.banner')
<div class='container'>
    <div class='row'>
        <div class='col-sm-7 col-md-8'>
            <div class='panel panel-default'>
                <div class="panel-body">
                    <h3>{{$post->title}}</h3>
                    <small>Posted at {{$post->created_at}} by {{$post->user->name}}</small>
                    <hr>    
                    <div class='post-body'>
                        {!!$post->body!!}
                    </div>
                    <hr>
                    @if(!Auth::guest())
                        @if(Auth::user()->id == $post->user_id)
                            <a href='/b/{{$board->name}}/posts/{{$post->id}}/edit' class='btn btn-default'>Edit</a>
                            {!!Form::open(['action' => ['PostsController@destroy', $board->name, $post->id], 'method' => 'POST', 'style' => 'display: inline-block'])!!}
                                {{Form::hidden('_method', 'DELETE')}}
                                {{Form::submit('Delete', ['class' => 'btn btn-danger'])}}
                            {!!Form::close()!!}
                        @endif
                    @endif
                </div>
            </div>
            <div class='panel panel-default'>
                <div class="panel-body">
                    <h2>Comments</h2>
                    <hr>
                </div>
            </div>
        </div>
        @include('inc.sidebar')
    </div>
</div>
@endsection