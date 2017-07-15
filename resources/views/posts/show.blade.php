@extends('layouts.app')

@section('content')
    <h1>{{$post->title}}</h1>
    <small>Posted at {{$post->created_at}}</small>
    <hr>    
    <p>
        {!!$post->body!!}
    </p>
    <hr>

    <a href='/posts/{{$post->id}}/edit' class='btn btn-default'>Edit</a>
    {!!Form::open(['action' => ['PostsController@destroy', $post->id], 'method' => 'POST', 'style' => 'display: inline-block'])!!}
        {{Form::hidden('_method', 'DELETE')}}
        {{Form::submit('Delete', ['class' => 'btn btn-danger'])}}
    {!!Form::close()!!}
    
@endsection