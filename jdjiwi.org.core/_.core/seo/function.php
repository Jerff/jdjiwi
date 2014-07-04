<?php

function cRedirect($u) {
    header('Location: ' . $u);
    exit;
}

function cRedirectSeo($u) {
    header('HTTP/1.1 301 Moved Permanently: ' . $u);
    cRedirect($u);
}

?>