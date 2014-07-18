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
        foreach ($mFiles as $file) {
            $content .= "<?php\n#include $file\n?>"
                    . $this->parse($file)
                    . "<?php\n#end $file\n?>";
        }
        $content = preg_replace('#\?>\s*<\?php#S', ' ', $content);
        $content = str_replace("\r", '', $content);
        return $content;
    }

    private function file($file) {
        $content = cString::convertEncoding(php_strip_whitespace($file));
        $content = preg_replace_callback("#(\".*?\")|('.*?')|(\{.*?\})|((require|require_once|include|include_once)\('(.*?)'\);)#sS", array(&$this, 'includeFile'), $content);
        return $content;
    }

    private function includeFile($m) {
        if (!isset($m[6]))
            return $m[0];
        return ' ?>' . $this->file($m[6]) . '<?php ';
    }

    private function parse($file) {
        $arg = explode('::', $file);
        switch ($arg[0]) {
            case 'cLoader':
                $arg[1] = str_replace(':', '/lib/', $arg[1]);
                return '<?php cLoader::setHistory(\'' . $arg[1] . '\'); ?>' .
                        $this->file($arg[1] . '.php');

            case 'cConfig':
                $code = '';
                foreach (cConfig::getFiles($arg[1]) as $file) {
                    $code .= PHP_EOL . '<?php cConfig::set(\'' . $arg[1] . '\', \'' . $file . '\', function(){ ?>' . file_get_contents(cConfig::path($file)) . '<?php }); ?>';
                }
                return $code;
                break;

            case 'cModul':
                return '<?php cModul::setItem(\'' . $arg[1] . '\', \'include\');' .
                        PHP_EOL . 'cModul::setHistory(\'' . $arg[2] . '\', \'include\'); ?>' .
                        $this->file($arg[2]);
            default:
                break;
        }
        return $this->file($file);
    }

}

?>