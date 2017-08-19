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