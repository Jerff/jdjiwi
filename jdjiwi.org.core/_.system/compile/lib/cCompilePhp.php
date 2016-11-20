<?php

\Jdjiwi\Loader::library('core:crypt/cCrypt');
\Jdjiwi\Loader::library('core:string/cString');

class cCompilePhp {
    /*
     *  compile sourse path
     */

    public function load($type, $file) {
        if (\Jdjiwi\Config::get('compile.is') < 2) {
            return $file;
        }
        $hash = cCrypt::hash(\Jdjiwi\Loader::getIndex(), $type, $file);
        $compile = \Jdjiwi\Config::get('compile.path') . $type . '/' . substr($hash, 0, 1) . '/' . substr($hash, 1, 2) . '/' . $hash . '.php';
        if (file_exists($compile)) {
            return $compile;
        }
        \Jdjiwi\Loader::initLoad();
        cFileSystem::mkdir(dirname($compile));
        require_once ($file);
        file_put_contents($compile, $this->compile(\Jdjiwi\Loader::getLoadFile()));
    }

    /*
     * update
     */

    public function createrLoader() {
        cFileSystem::mkdir(\Jdjiwi\Config::get('compile.path'));
        file_put_contents(
                \Jdjiwi\Config::get('compile.path') . cCompile::config()->loaderPhp(), cCompile::php()->compile(\Jdjiwi\Loader::getLoadFile())
        );
    }

    public function update() {
        cFileSystem::rmdir(\Jdjiwi\Config::get('compile.path'));
    }

    public function compile($mFiles) {
        $compile = $loader = $history = $content = '';
        foreach ($mFiles as $file) {
            $code = "<?php\n#include {$file}\n?>"
                    . $this->parse($file)
                    . "?><?php\n#end {$file}\n?>";
            $arg = explode('::', $file);
            switch ($arg[0]) {
                case 'Config':
                case 'Modul':
                    $compile .= "<?php \Jdjiwi\Loader\Compile::compile('{$file}', function() { ?>{$code}<?php }); ?>";
                    break;

                case 'Loader':
                    switch ($file) {
                        case '\Jdjiwi\Loader::loader/compile/Compile':
                            $history .= "<?php \Jdjiwi\Loader::setHistory('{$arg[1]}'); ?>";
                            $loader .= $code;
                            break;

                        default:
                            $history .= "<?php \Jdjiwi\Loader::setHistory('{$arg[1]}'); ?>";
                            $content .= $code;
                            break;
                    }
                    break;

                default:
                    break;
            }
        }
        $content .="<?php \Jdjiwi\Modul::load('loader'); ?>";
        $content = preg_replace('#\?>\s*<\?php#S', ' ', $loader . $compile . $history . $content);
        $content = str_replace("\r", '', $content);
        return $content;
    }

    private $itemFile = false;

    private function file($file) {
        $this->itemFile = $file;
        $content = cString::convertEncoding(php_strip_whitespace($file));
        $content = trim(preg_replace_callback("#(\".*?\")|('.*?')|(\{.*?\})|((require|require_once|include|include_once)\('(.*?)'\);)#sS", array(&$this, 'includeFile'), $content));
        if (substr($content, -2) === '?>') {
            $content = substr($content, 0, -2);
        }
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
            case 'Loader':
            case 'Config':
            case 'Modul':
                return $this->file($arg[1] . '.php');

            default:
                break;
        }
        return $this->file($file);
    }

}
