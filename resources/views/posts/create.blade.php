@extends('layouts.app')

@section('content')
@include('inc.banner')
<div class='container'>
    <h1>Create Post</h1>
    @include('inc.errors')
    {!! Form::open(['action' => array('PostsController@store', $board->name), 'method' => 'POST']) !!}
        <div class="form-group">
            {{Form::label('title', 'Title')}}
            {{Form::text('title', '', ['class' => 'form-control', 'placeholder' => 'Title'])}}
        </div>

        <div class="form-group">
            {{Form::label('body', 'Body')}}
            {{Form::textarea('body', '', ['id' => 'article-ckeditor', 'class' => 'form-control', 'placeholder' => 'Body Text'])}}
        </div>
         {{Form::hidden('board', $board->name)}}
        {{Form::submit('Submit', ['class' => 'btn btn-primary'])}}
    {!! Form::close() !!}

</div>
@endsection