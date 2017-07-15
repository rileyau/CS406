@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Your Blog Posts</div>

                <div class="panel-body">
                    @if(count($posts) > 0)
                        <table class='table table-striped table-hover'>
                            <tr>
                                <th>Title</th>
                                <th></th>
                            </tr>
                            @foreach($posts as $post)
                                <tr>
                                    <td>{{$post->title}}</td>
                                    <td style='text-align: right'>
                                        <a href='/posts/{{$post->id}}/edit' class='btn btn-primary'>Edit</a>
                                    
                                        {!!Form::open(['action' => ['PostsController@destroy', $post->id], 'method' => 'POST', 'style' => 'display: inline-block'])!!}
                                            {{Form::hidden('_method', 'DELETE')}}
                                            {{Form::submit('Delete', ['class' => 'btn btn-danger'])}}
                                        {!!Form::close()!!}
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    @else
                        <p>You have no posts yet</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
