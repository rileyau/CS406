@php
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
@endphp
Submitted {{$output}}