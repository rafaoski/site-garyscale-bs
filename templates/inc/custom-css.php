<?php namespace ProcessWire;
$css = "header.masthead {
        background: -webkit-gradient(linear,left top,left bottom,
        from(rgba(22,22,22,.1)),color-stop(75%,rgba(22,22,22,.5)),to(#161616)),
        url($header_image);
        background: linear-gradient(to bottom,rgba(22,22,22,.1) 0,rgba(22,22,22,.5) 75%,#161616 100%),
                    url($header_image);
            background-position-x: 0%, 0%;
            background-position-y: 0%, 0%;
            background-repeat: repeat, repeat;
            background-attachment: scroll, scroll;
            background-size: auto auto, auto auto;
        background-position: center;
        background-repeat: no-repeat;
        background-attachment: scroll;
        background-size: cover;
}";
 if(page()->template == 'home' or page()->template == 'signup' ) {
    $css .= ".signup-section {
        padding: 10rem 0;
        background: -webkit-gradient(linear,left top,left bottom,
        from(rgba(22,22,22,.1)),color-stop(75%,rgba(22,22,22,.5)),
        to(#161616)),url($bg_signup);
        background: linear-gradient(to bottom,rgba(22,22,22,.1) 0,rgba(22,22,22,.5) 75%,#161616 100%),url($bg_signup);
            background-position-x: 0%, 0%;
            background-position-y: 0%, 0%;
            background-repeat: repeat, repeat;
            background-attachment: scroll, scroll;
            background-size: auto auto, auto auto;
        background-position: center;
        background-repeat: no-repeat;
        background-attachment: scroll;
        background-size: cover;
    }
    .hide-robot {
        display: none;
    }";
}

// MINIFY CSS => make it into one long line
$css = str_replace(array("\n","\r"),'',$css);
// replace all multiple spaces by one space
$css = preg_replace('!\s+!',' ',$css);
// replace some unneeded spaces, modify as needed
$css = str_replace(array(' {',' }','{ ','; '),array('{','}','{',';'),$css);
echo "$css\n";
