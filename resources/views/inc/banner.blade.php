<div class='jumbotron' style='background-image: url("/storage/cover_images/{{$board->banner_image}}"); background-size: cover; margin: 0px;'>
        <div class='container board-banner'>
            <h1><a href='/b/{{$board->name}}' class='banner-text'>{{$board->name}}</a></h1>
        </div>
    </div>

    <nav class="navbar navbar-default">
        <div class="container">            
                <ul class="nav navbar-nav" id='center-nav'>
                    <li><a href="/b/{{$board->name}}">Hot</a></li>
                    <li><a href='/b/{{$board->name}}/top'>Top</a></li>
                    <li><a href="/b/{{$board->name}}/rising">Rising</a></li>
                    <li><a href="/b/{{$board->name}}/new">New</a></li>
                </ul>
            
        </div>
    </nav>