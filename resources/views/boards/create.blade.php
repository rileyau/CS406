@extends('layouts.app')

@section('content')
<div class='container'>
    <br>
    <h1>Create a New Board</h1>
    <br>
    @include('inc.errors')
    {!! Form::open(['action' => 'BoardsController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
        <div class="form-group">
            {{Form::label('name', 'Name')}}
            {{Form::text('name', '', ['class' => 'form-control', 'placeholder' => 'Name'])}}
            <small>Board names must be unique and contain 50 or less alpha-numeric charcters</small>
        </div>

        <div class="form-group">
            {{Form::label('description', 'Description')}}
            {{Form::textarea('description', '', ['id' => 'article-ckeditor', 'class' => 'form-control', 'placeholder' => 'Explain to newcomers what this board is all about'])}}
        </div>

        <div class='form-group'>
            {{Form::label('cover_image', 'Banner Image')}}
            {{Form::file('cover_image')}}
            <br>
            <small>The banner image will be displayed at the top of your board and will be 200px tall and fill the screen</small>
            
        </div>
        <hr>
        {{Form::submit('Submit', ['class' => 'btn btn-primary'])}}
    {!! Form::close() !!}

</div>
@endsection