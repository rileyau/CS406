<div class='col-sm-5 col-md-4'>
    <div class='panel panel-default'>
        <div class="panel-body">
            <a href='/b/{{$board->name}}/posts/create' class='btn btn-primary btn-lg btn-block' style='margin-bottom: 10px;'>Submit Post</a>
            @if(!$subbed)
                {!! Form::open(['action' => ['SubscriptionsController@store', $board->name], 'method' => 'POST']) !!}
                    <input type='submit' class='btn btn-default btn-lg btn-block' value='Subscribe'>
                {!! Form::close() !!}
            @else 
                {!! Form::open(['action' => ['SubscriptionsController@destroy', $board->name], 'method' => 'POST']) !!}
                    {{Form::hidden('_method', 'DELETE')}}
                    <input type='submit' class='btn btn-danger btn-lg btn-block' value='Unsubscribe'>
                {!! Form::close() !!}
            @endif
            <hr>
                <div class="input-group">
                    <input type="text" class="form-control" name="x" placeholder="Search term...">
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="button"><span class="glyphicon glyphicon-search"></span></button>
                    </span>
                </div>
                <br>
                <div class='form-group'>
                    <label class="form-check-label">
                    &nbsp<input type="checkbox" class="form-check-input">
                    &nbsp Limit search to this board
                    </label>
                </div>                        
            <hr>
                {!! $board->description !!}
            <hr>
            <a href='/b/{{$board->name}}/edit' class='btn btn-default'>Edit Board</a> <a href='#' class='btn btn-danger'>Lock Board</a>
        </div>
    </div>
</div>