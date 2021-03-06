@extends('layouts.app')

@section('content')
@include('inc.home-banner')
    <div class='container'>
        @if(count($posts) < 1)
            <h2>There is nothing to show!</h2>
            <p>Posts from boards you subscribe to will show up here. </p> 
        @endif
        @foreach($posts as $post)
            <div class='well well-sm'>
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
            
                <div>
                    <h4><a href='/b/{{$post->board}}/posts/{{$post->id}}'>{{$post->title}}</a></h4>
                    <small>@include('inc.dateFormat') by {{$post->user->name}} on <strong><a href='/b/{{$post->board}}'>{{$post->board}}</a></strong></small>
                </div>
                
            </div>
        @endforeach 
        {{$links->links()}}  
    </div>
    
@endsection