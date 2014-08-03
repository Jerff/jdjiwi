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
            return $compile;
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
        $compile = $loader = $history = $content = '';
        foreach ($mFiles as $file) {
            $code = "<?php\n#include {$file}\n?>"
                    . $this->parse($file)
                    . "?><?php\n#end {$file}\n?>";
            $arg = explode('::', $file);
            switch ($arg[0]) {
                case 'cConfig':
                case 'cModul':
                    $compile .= "<?php cLoaderCompile::compile('{$file}', function() { ?>{$code}<?php }); ?>";
                    break;

                case 'cLoader':
                    switch ($file) {
                        case 'cLoader::loader/compile/cLoaderCompile':
                            $history .= "<?php cLoader::setHistory('{$arg[1]}'); ?>";
                            $loader .= $code;
                            break;

                        default:
                            $history .= "<?php cLoader::setHistory('{$arg[1]}'); ?>";
                            $content .= $code;
                            break;
                    }
                    break;

                default:
                    break;
            }
        }
        $content .="<?php cModul::load('loader'); ?>";
        $content = preg_replace('#\?>\s*<\?php#S', ' ', $loader . $compile . $history . $content);
        $content = str_replace("\r", '', $content);
        return $content;
    }

    private $itemFile = false;

    private function file($file) {
        $this->itemFile = $file;
        $content = cString::convertEncoding(php_strip_whitespace($file));
        $content = preg_replace_callback("#(\".*?\")|('.*?')|(\{.*?\})|((require|require_once|include|include_once)\('(.*?)'\);)#sS", array(&$this, 'includeFile'), $content);
        return $content;
    }

    private function includeFile($m) {
        if (!isset($m[6]))
            return $m[0];
        //realpath
        return $this->file($m[6]);
    }

    private function parse($file) {
        $arg = explode('::', $file);
        switch ($arg[0]) {
            case 'cLoader':
            case 'cConfig':
            case 'cModul':
                return $this->file($arg[1] . '.php');

            default:
                break;
        }
        return $this->file($file);
    }

}
