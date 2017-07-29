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
                        
                        <div class='pull-left rating-buttons'>
                            <button type="button" class="btn btn-default btn-sm" style='margin-bottom: 3px'>
                                <span class="glyphicon glyphicon-chevron-up"></span>
                            </button><br>
                            <button type="button" class="btn btn-default btn-sm">
                                <span class="glyphicon glyphicon-chevron-down"></span>
                            </button>
                        </div>
                        <div>
                            <h5><a href='/b/{{$board->name}}/posts/{{$post->id}}'>{{$post->title}}</a></h5>
                            <small>Submitted {{$post->created_at}} by {{$post->user->name}}</small>
                        </div>
                        
                    </div>
                @endforeach 
                {{$posts->links()}}  
            </div>
            @include('inc.sidebar')
        </div>
    </div>
    
@endsection