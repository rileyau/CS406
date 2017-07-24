@extends('layouts.app')

@section('content')
<div class='container'>
    <h1>{{$post->title}}</h1>
    <small>Posted at {{$post->created_at}} by {{$post->user->name}}</small>
    <hr>    
    <p>
        {!!$post->body!!}
    </p>
    <hr>
    @if(!Auth::guest())
        @if(Auth::user()->id == $post->user_id)
            <a href='/posts/{{$post->id}}/edit' class='btn btn-default'>Edit</a>
            {!!Form::open(['action' => ['PostsController@destroy', $post->id], 'method' => 'POST', 'style' => 'display: inline-block'])!!}
                {{Form::hidden('_method', 'DELETE')}}
                {{Form::submit('Delete', ['class' => 'btn btn-danger'])}}
            {!!Form::close()!!}
        @endif
    @endif
</div>
@endsection