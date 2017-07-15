@extends('layouts.app')

@section('content')
    <h1>Posts</h1>
    @if(count($posts) > 0)
        @foreach($posts as $post)
            <div class="well">
                <div class='row'>
                    <div class='col-md-2 col-sm-2'>
                        <img style='width: 100%' src='/storage/cover_images/{{$post->cover_image}}' />
                    </div>
                    <div class='col-md-10 col-sm-10'>
                        <a href='posts/{{$post->id}}'><h3>{{$post->title}}</h3></a>
                        <small>Written on {{$post->created_at}} by {{$post->user->name}}</small>
                    </div>
                </div>                
            </div>  
        @endforeach
        {{$posts->links()}}
    @else
        <p>You don't have any posts.</p>
    @endif

@endsection