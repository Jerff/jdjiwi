<?php

use Jdjiwi\Debug;

function isDebug() {
    return Debug::isError();
}

function pre() {
    if (!Debug::isError())
        return;
    echo '<pre>';
    foreach (func_get_args() as $value)
        if (is_array($value) or is_object($value)) {
            print_r($value);
        } else {
            var_dump($value);
        }
    echo '</pre>';
}

function pre2() {
    if (!Debug::isError())
        return;
    echo '<pre>';
    foreach (func_get_args() as $value) {
        print("\n\n" . $value);
    }
    echo '</pre>';
}

function pre3() {
    if (!Debug::isError())
        return;
    echo '<pre>';
    foreach (func_get_args() as $value) {
        print("\n\n" . htmlspecialchars($value));
    }
    echo '</pre>';
}

function preTrace() {
    if (!Debug::isError())
        return;
    echo '<pre>';
    echo (new Exception())->getTraceAsString();
    echo '</pre>';
}
