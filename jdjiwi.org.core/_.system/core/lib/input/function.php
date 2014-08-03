<?php

function get($v, $k, $d = null) {
    if (isset($v[$k]))
        return $v[$k];
    else
        return $d;
}

function get2($v, $k, $k2, $d = null) {
    if (isset($v[$k][$k2]))
        return $v[$k][$k2];
    else
        return $d;
}

function get3($v, $k, $k2, $k3, $d = null) {
    if (isset($v[$k][$k2][$k3]))
        return $v[$k][$k2][$k3];
    else
        return $d;
}

