@extends('layouts.app')

@section('content')
<div class='container'>
    <br>
    <h1>Edit Board</h1>
    <br>
    {!! Form::open(['action' => ['BoardsController@update', $board->name], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
        <div class="form-group">
            {{Form::label('name', 'Name')}}
            {{Form::text('name', $board->name, ['class' => 'form-control', 'placeholder' => 'Name'])}}
            <small>Board names must be unique and contain 50 or less alpha-numeric charcters</small>
        </div>

        <div class="form-group">
            {{Form::label('description', 'Description')}}
            {{Form::textarea('description', $board->description, ['id' => 'article-ckeditor', 'class' => 'form-control', 'placeholder' => 'Explain to newcomers what this board is all about'])}}
        </div>

        <div class='form-group'>
            {{Form::label('cover_image', 'Banner Image')}}
            {{Form::file('cover_image')}}
            <br>
            <small>The banner image will be displayed at the top of your board and will be 200px tall and fill the screen</small>
            
        </div>
        <hr>
        {{Form::hidden('_method', 'PUT')}}
        {{Form::submit('Submit', ['class' => 'btn btn-primary'])}}
    {!! Form::close() !!}

</div>
@endsection