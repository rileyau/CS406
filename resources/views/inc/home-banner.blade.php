<div class='jumbotron' style='background: linear-gradient(141deg, #222 0%, #555 51%, #777 95%); background-size: cover; margin: 0px;'>
    <div class='container board-banner'>
        <h1><a href='/' class='banner-text'>MyReddit</a></h1>
    </div>
</div>

<nav class="navbar navbar-default">
    <div class="container">            
            <ul class="nav navbar-nav" id='center-nav'>
                @if(!Auth::guest())
                    <li><a href="/">All</a></li>
                    <li><a href='/subbed'>My Subscriptions</a></li>
                @endif
            </ul>
    </div>
</nav>