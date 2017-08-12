@extends('layouts.app')

@section('content')
@include('inc.banner')
<div class='container'>
    <div class='row'>
        <div class='col-sm-7 col-md-8'>
            <div class='panel panel-default'>
                <div class="panel-body">
                    <div class='pull-left rating'>
                        <strong>{{$post->totalRating()}}</strong>
                    </div>
                    @if(!Auth::guest())
                        <div class='pull-left rating-buttons'>

                            @if($post->userHasRated(Auth::user()->id) == 1)

                                {!! Form::open(['action' => ['UserPostRatingsController@destroy', $post->id], 'method' => 'POST', 'style' => 'display: inline;']) !!}
                                    {!! Form::hidden('_method', 'DELETE') !!}
                                    <button type="submit" class="btn btn-primary btn-sm" style='margin-bottom: 3px'>
                                        <span class="glyphicon glyphicon-chevron-up"></span>
                                    </button>
                                {!! Form::close() !!}
                                <br>
                                {!! Form::open(['action' => ['UserPostRatingsController@update', $post->id], 'method' => 'POST', 'style' => 'display: inline;']) !!}
                                    {!! Form::hidden('rating', -1) !!}
                                    {!! Form::hidden('_method', 'PUT') !!}
                                    <button type="submit" class="btn btn-default btn-sm" style='margin-bottom: 3px'>
                                        <span class="glyphicon glyphicon-chevron-down"></span>
                                    </button>
                                {!! Form::close() !!}

                            @elseif($post->userHasRated(Auth::user()->id) == -1)

                                {!! Form::open(['action' => ['UserPostRatingsController@update', $post->id], 'method' => 'POST', 'style' => 'display: inline;']) !!}
                                    {!! Form::hidden('rating', 1) !!}
                                    {!! Form::hidden('_method', 'PUT') !!}
                                    <button type="submit" class="btn btn-default btn-sm" style='margin-bottom: 3px'>
                                        <span class="glyphicon glyphicon-chevron-up"></span>
                                    </button>
                                {!! Form::close() !!}
                                <br>
                                {!! Form::open(['action' => ['UserPostRatingsController@destroy', $post->id], 'method' => 'POST', 'style' => 'display: inline;']) !!}
                                    {!! Form::hidden('_method', 'DELETE') !!}
                                    <button type="submit" class="btn btn-danger btn-sm" style='margin-bottom: 3px'>
                                        <span class="glyphicon glyphicon-chevron-down"></span>
                                    </button>
                                {!! Form::close() !!}

                            @else 

                                {!! Form::open(['action' => ['UserPostRatingsController@rate', $post->id], 'method' => 'POST', 'style' => 'display: inline;']) !!}
                                    {!! Form::hidden('rating', 1) !!}
                                    <button type="submit" class="btn btn-default btn-sm" style='margin-bottom: 3px'>
                                        <span class="glyphicon glyphicon-chevron-up"></span>
                                    </button>
                                {!! Form::close() !!}
                                <br>
                                {!! Form::open(['action' => ['UserPostRatingsController@rate', $post->id], 'method' => 'POST', 'style' => 'display: inline;']) !!}
                                    {!! Form::hidden('rating', -1) !!}
                                    <button type="submit" class="btn btn-default btn-sm" style='margin-bottom: 3px'>
                                        <span class="glyphicon glyphicon-chevron-down"></span>
                                    </button>
                                {!! Form::close() !!}

                            @endif                   
                
                        </div>
                    @endif
                    <div class='post-title'> <h3>{{$post->title}}</h3> </div>
                    <?php 
                                $date = new DateTime($post->created_at);
                                $now = new DateTime();
                                $ago = $date->diff($now)->format("%y %m %d %h %i");
                                $pieces = explode(" ", $ago);


                                if((int)$pieces[0] > 0) {
                                    $piece = $pieces[0];
                                    $output = $piece;
                                    if($piece > 1)  {
                                        $output = $output." years ago";
                                    }
                                    else {
                                        $output = $output." year ago";
                                    }
                                }

                                else if((int)$pieces[1] > 0) {
                                    $piece = $pieces[1];
                                    $output = $piece;
                                    if($piece > 1)  {
                                        $output = $output." months ago";
                                    }
                                    else {
                                        $output = $output." month ago";
                                    }
                                }

                                else if((int)$pieces[2] > 0) {
                                    $piece = $pieces[2];
                                    $output = $piece;
                                    if($piece > 1)  {
                                        $output = $output." days ago";
                                    }
                                    else {
                                        $output = $output." day ago";
                                    }
                                }

                                else if((int)$pieces[3] > 0) {
                                    $piece = $pieces[3];
                                    $output = $piece;
                                    if($piece > 1)  {
                                        $output = $output." hours ago";
                                    }
                                    else {
                                        $output = $output." hour ago";
                                    }
                                }

                                else if((int)$pieces[4] > 0) {
                                    $piece = $pieces[4];
                                    $output = $piece;
                                    if($piece > 1)  {
                                        $output = $output." minutes ago";
                                    }
                                    else {
                                        $output = $output." minute ago";
                                    }
                                }

                                else {
                                    $output = "less than a minute ago";
                                }
                            ?>
                    <small>Posted {{$output}} by {{$post->user->name}}</small>
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