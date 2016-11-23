<?php

\Jdjiwi\Config::load('file');
\Jdjiwi\Config::load('path');
\Jdjiwi\Modul::config('const');

\Jdjiwi\Loader::library('file:Exception');
\Jdjiwi\Loader::library('file:path/cPath');
\Jdjiwi\Loader::library('file:system/cFileSystem');
\Jdjiwi\Loader::library('file:cDir');
\Jdjiwi\Loader::library('file:cFile');
\Jdjiwi\Loader::library('file:upload/cFileUpload');
\Jdjiwi\Loader::library('file:image/cImage');