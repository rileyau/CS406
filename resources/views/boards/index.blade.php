@extends('layouts.app')

@section('content')
@include('inc.banner')

    <div class='container'>
        <div class='row'>
            <div class='col-sm-7 col-md-8'>
                @if(count($posts) < 1)
                    <h2>There is nothing to show!</h2>
                    <p>Start a discussion by clickling on 'Submit Post'</p> 
                @endif
                @foreach($posts as $post)
                    <div class='well well-sm'>
                        <div class='pull-left rating'>
                        <strong>{{$post->totalRating()}}</strong>
                    </div>
                    @if(!Auth::guest())
                        @include('inc.voteButtons')
                    @endif
                        <div>
                            <h4><a href='/b/{{$board->name}}/posts/{{$post->id}}'>{{$post->title}}</a></h4>
                            
                            <small>@include('inc.dateFormat') by {{$post->user->name}}</small>
                        </div>
                        
                    </div>
                @endforeach 
                {{$links->links()}}  
            </div>
            @include('inc.sidebar')
        </div>
    </div>
    
@endsection