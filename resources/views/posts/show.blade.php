@extends('layouts.app')

@section('content')
    <h1>{{$post->title}}</h1>
    <small>Posted at {{$post->created_at}}</small>
    <hr>    
    <p>
        {{$post->body}}
    </p>
    
@endsection