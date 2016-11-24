<?php

\Jdjiwi\Config::load('file');
\Jdjiwi\Config::load('path');
\Jdjiwi\Modul::config('const');

\Jdjiwi\Loader::library('fileSystem:Exception');
\Jdjiwi\Loader::library('fileSystem:path/cPath');
\Jdjiwi\Loader::library('fileSystem:system/cFileSystem');
\Jdjiwi\Loader::library('fileSystem:cDir');
\Jdjiwi\Loader::library('fileSystem:cFile');
\Jdjiwi\Loader::library('fileSystem:upload/cFileUpload');
\Jdjiwi\Loader::library('fileSystem:image/cImage');