<?php

cLoader::library('core:input/cInput');
cLoader::library('core:session/cSession');
cLoader::library('core:settings/cSettings');
cLoader::library('core:string/cString');
cLoader::library('core:jscript/cJScript');
cLoader::library('core:hashing/cHashing');
cLoader::library('core:time/cTime');
cLoader::library('core:header/cHeader');
cLoader::library('core:register/cRegister');

/* загрузка модулей */
cModul::load('seo');
cModul::load('pages');
cModul::load('cache');
?>