<?php

cLoader::library('core:crypt/cCrypt');
cLoader::library('core:string/cString');

class cCompilePhp {
    /*
     *  compile sourse path
     */

    public function load($type, $file) {
        if (cConfig::get('compile.is') < 2) {
            return $file;
        }
        $hash = cCrypt::hash(cLoader::getIndex(), $type, $file);
        $compile = cConfig::get('compile.path') . $type . '/' . substr($hash, 0, 1) . '/' . substr($hash, 1, 2) . '/' . $hash . '.php';
        if (file_exists($compile)) {
            if (cConfig::get('compile.is') == 3)
                return $compile;
            else {
                if (filemtime($file) < filemtime($compile))
                    return $compile;
            }
        }
        cLoader::initLoad();
        cFileSystem::mkdir(dirname($compile));
        require_once ($file);
        file_put_contents($compile, $this->compile(cLoader::getLoadFile()));
    }

    /*
     * update
     */

    public function createrLoader() {
        cFileSystem::mkdir(cConfig::get('compile.path'));
        file_put_contents(
                cConfig::get('compile.path') . cCompile::config()->loaderPhp(), cCompile::php()->compile(cLoader::getLoadFile())
        );
    }

    public function update() {
        cFileSystem::rmdir(cConfig::get('compile.path'));
    }

    public function compile($mFiles) {
        $content = '';
        pre($mFiles);
        exit;
        foreach ($mFiles as $file) {
            $content .= "<?php\n#include $file\n?>"
                    . cString::convertEncoding(php_strip_whitespace($file))
                    . "<?php\n#end $file\n?>";
        }
        $content = preg_replace('#\?>\s*<\?php#S', ' ', $content);
        $content = str_replace("\r", '', $content);
        return $content;
    }

}

?>