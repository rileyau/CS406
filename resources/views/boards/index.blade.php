@extends('layouts.app')

@section('content')
@include('inc.banner')

    <div class='container'>
        <div class='col-md-8'>
                @if(count($posts) < 1)
                    <h2>There is nothing to show!</h2>
                    <p>Start a discussion by clickling on 'Submit Post'</p> 
                @endif
                @foreach($posts as $post)
                    <div class='well well-sm'>
                        <h5><a href='/b/{{$board->name}}/posts/{{$post->id}}'>{{$post->title}}</a></h5>
                        <small>Submitted {{$post->created_at}} by {{$post->user->name}}</small>
                    </div>
                @endforeach 
                {{$posts->links()}}  
        </div>
        <div class='col-md-4'>
            <div class='panel panel-default'>
                <div class="panel-body">
                    <a href='./{{$board->name}}/posts/create' class='btn btn-primary btn-lg btn-block'>Submit Post</a>
                    <a href='#' class='btn btn-default btn-lg btn-block'>Subscribe</a>
                    <hr>
                        <div class="form-group">
                            {{Form::text('search', '', ['class' => 'form-control', 'placeholder' => 'Search'])}}
                            <br>
                            {{Form::checkbox('limit', 1, true)}} {{Form::label('limit', 'Limit search to this board')}}

                        </div>
                    <hr>
                    <p>This is the description for the board. Put information here to let users know what type of content is appropriate for this board.</p>
                    <p>You might consider putting the rules for the kind of content you are willing to allow on your board or include other relavent information.</p>
                    <hr>
                    <a href='#' class='btn btn-default'>Edit Board</a> <a href='#' class='btn btn-danger'>Lock Board</a>
                </div>
            </div>
        </div>
    </div>
    
@endsection