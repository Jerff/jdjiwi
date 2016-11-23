<?php

namespace Jdjiwi;

function Redirect($u) {
    header('Location: ' . $u);
    exit;
}

function Redirect301($u) {
    header('HTTP/1.1 301 Moved Permanently: ' . $u);
    Redirect($u);
}
