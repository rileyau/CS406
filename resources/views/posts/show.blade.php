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
                    <div class='post-title'> <h3>{{$post->title}}</h3> 
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
                    </div>
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
            @if(!Auth::guest())
            <div class='panel panel-default'>
                <div class="panel-body">
                    <h2>Comment</h2>
                    <hr>
                    @include('inc.errors')
                     {!! Form::open(['action' => ['CommentsController@store', $post->board, $post->id], 'method' => 'POST']) !!}
                        <div class="form-group">
                            {{Form::label('body', 'Body')}}
                            {{Form::textarea('body', '', ['id' => 'article-ckeditor', 'class' => 'form-control', 'placeholder' => 'Post your reply'])}}
                        </div>
                        {{Form::hidden('board', $board->name)}}
                        {{Form::submit('Reply', ['class' => 'btn btn-primary'])}}
                    {!! Form::close() !!}

                </div>
            </div>
            @endif
                @foreach($comments as $comment)
                    <?php 
                    $date = new DateTime($comment->updated_at);
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
                    <div class='well well-sm comment'>
                    <div class='pull-left comment-rating'>
                        <strong>{{$post->totalRating()}}</strong>
                    </div>
                    @if(!Auth::guest())
                        <div class='pull-left comment-rating-buttons'>

                            @if($post->userHasRated(Auth::user()->id) == 1)

                                {!! Form::open(['action' => ['UserPostRatingsController@destroy', $post->id], 'method' => 'POST', 'style' => 'display: inline;']) !!}
                                    {!! Form::hidden('_method', 'DELETE') !!}
                                    <button type="submit" class="btn btn-primary btn-xs" style='margin-bottom: 3px'>
                                        <span class="glyphicon glyphicon-chevron-up"></span>
                                    </button>
                                {!! Form::close() !!}
                                <br>
                                {!! Form::open(['action' => ['UserPostRatingsController@update', $post->id], 'method' => 'POST', 'style' => 'display: inline;']) !!}
                                    {!! Form::hidden('rating', -1) !!}
                                    {!! Form::hidden('_method', 'PUT') !!}
                                    <button type="submit" class="btn btn-default btn-xs" style='margin-bottom: 3px'>
                                        <span class="glyphicon glyphicon-chevron-down"></span>
                                    </button>
                                {!! Form::close() !!}

                            @elseif($post->userHasRated(Auth::user()->id) == -1)

                                {!! Form::open(['action' => ['UserPostRatingsController@update', $post->id], 'method' => 'POST', 'style' => 'display: inline;']) !!}
                                    {!! Form::hidden('rating', 1) !!}
                                    {!! Form::hidden('_method', 'PUT') !!}
                                    <button type="submit" class="btn btn-default btn-xs" style='margin-bottom: 3px'>
                                        <span class="glyphicon glyphicon-chevron-up"></span>
                                    </button>
                                {!! Form::close() !!}
                                <br>
                                {!! Form::open(['action' => ['UserPostRatingsController@destroy', $post->id], 'method' => 'POST', 'style' => 'display: inline;']) !!}
                                    {!! Form::hidden('_method', 'DELETE') !!}
                                    <button type="submit" class="btn btn-danger btn-xs" style='margin-bottom: 3px'>
                                        <span class="glyphicon glyphicon-chevron-down"></span>
                                    </button>
                                {!! Form::close() !!}

                            @else 

                                {!! Form::open(['action' => ['UserPostRatingsController@rate', $post->id], 'method' => 'POST', 'style' => 'display: inline;']) !!}
                                    {!! Form::hidden('rating', 1) !!}
                                    <button type="submit" class="btn btn-default btn-xs" style='margin-bottom: 3px'>
                                        <span class="glyphicon glyphicon-chevron-up"></span>
                                    </button>
                                {!! Form::close() !!}
                                <br>
                                {!! Form::open(['action' => ['UserPostRatingsController@rate', $post->id], 'method' => 'POST', 'style' => 'display: inline;']) !!}
                                    {!! Form::hidden('rating', -1) !!}
                                    <button type="submit" class="btn btn-default btn-xs" style='margin-bottom: 3px'>
                                        <span class="glyphicon glyphicon-chevron-down"></span>
                                    </button>
                                {!! Form::close() !!}

                            @endif                   
                
                        </div>
                    @endif
                        <div class='comment-info'><span class='comment-name'>{{$comment->user->name}}</span><br> <small>{{$output}}</small></div>
                        <hr style='margin-top: 15px'>
                        <div class='comment-body'>
                            {!!$comment->body!!}
                        </div>
                        @if($comment->user_id == Auth::user()->id)
                        <hr style='margin: 15px 0px'> 
                            <button type='submit' class='btn btn-sm btn-default' data-toggle="modal" data-target="#editModal{{$comment->id}}"> &nbsp; Edit  &nbsp;</button> &nbsp;
                            {!! Form::open(['action' => ['CommentsController@destroy', $post->board, $post->id, $comment->id], 'method' => 'POST', 'style' => 'display: inline;']) !!}
                                {!! Form::hidden('_method', 'DELETE')!!}
                                 <button type='submit' class='btn btn-sm btn-danger'>Delete</button>
                            {!! Form::close() !!}

                            <!-- Modal -->
                            <div class="modal fade" id="editModal{{$comment->id}}" role="dialog">
                                <div class="modal-dialog">
                                
                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Edit Comment</h4>
                                    </div>
                                    <div class="modal-body">
                                    {!! Form::open(['action' => ['CommentsController@update', $post->board, $post->id, $comment->id], 'method' => 'POST', 'style' => 'display: inline;', 'id' =>'form'.$comment->id]) !!}
                                        {{Form::textarea('body', $comment->body, ['id' => 'article-ckeditor', 'class' => 'form-control', 'placeholder' => 'Post your reply'])}}
                                        {!! Form::hidden('_method', 'PUT')!!}
                                        
                                    </div>
                                    <div class="modal-footer">
                                    <button class='btn btn-primary' onclick="submitEdit('{{$comment->id}}', '{{$post->board}}', '{{$post->id}}');">Save</button>
                                        {!! Form::close() !!}
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                                
                                </div>
                            </div>                            
                        @endif
                        
                    </div>
                @endforeach
        </div>
        
        @include('inc.sidebar')
    </div>
</div>
<script type="text/javascript">
    function submitEdit(id, board, post) {
        console.log(id + " " + board + " " + " " + post);
        var modalId = '#editModal' + id;
        var text = $(modalId + ' textarea').val();
        var mydata = $("#form" + id).serialize();

        console.log(mydata);
        
        $.ajax({
            url: '/b/' + board + '/posts/' + post + '/comments/' + id,
            type: 'POST',
            data: mydata,
            success: function (data) {
                window.location.href='/b/' + board + '/posts/' + post ;
            }
        });

        
  }
</script>
@endsection