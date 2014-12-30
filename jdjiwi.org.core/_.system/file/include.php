<?php

cConfig::load('file');
cConfig::load('path');
cModul::config('const');

cLoader::library('file:path/cPath');
cLoader::library('file:system/cFileSystem');
cLoader::library('file:cDir');
cLoader::library('file:cFile');
cLoader::library('file:upload/cFileUpload');
cLoader::library('file:image/cImage');