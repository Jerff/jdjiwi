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
        $hash = cCrypt::hash(cLoader::getIndex(), cModul::getIndex(), cConfig::getIndex(), $type, $file);
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
        $this->createrLoader();
    }

    public function compile($mFiles) {
        $content = $start = '';
        $end = end($mFiles);
        foreach ($mFiles as $file) {
            $code = "<?php\n#include {$file}\n?>"
                    . $this->parse($file)
                    . "<?php\n#end {$file}\n?>";
            switch ($file) {
                case $end:
                case 'cLoader::loader/config/cConfig':
                case 'cLoader::loader/modul/cModul':
                    $start = $code . $start;
                    break;

                default:
                    $content .= "<?php cLoader::compile('{$file}', function() { ?>{$code}<?php }); ?>";
                    break;
            }
        }
        $content = preg_replace('#\?>\s*<\?php#S', ' ', $content);
        $content = str_replace("\r", '', $content);
        return $content . $start;
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
                return $this->file($arg[1] . '.php');

            case 'cConfig':
                $code = '';
                foreach (cConfig::getFiles($arg[1]) as $file) {
                    $code .= '<?php cConfig::set(\'' . $arg[1] . '\', \'' . $file . '\', function(){ ?>' . file_get_contents(cConfig::path($file)) . '<?php }); ?>';
                }
                return $code;
                break;

            case 'cModul':
                $code = "<?php cModul::setItem('{$arg[1]}'); ?>";
                $code.= "<?php cModul::setLoad('{$arg[1]}', '{$arg[2]}'); ?>";
                switch ($arg[2]) {
                    case 'call':
                        $code .= $this->file($arg[1] . '/include.php')
                                . $this->file($arg[1] . '/' . $arg[2] . '.php');

                    case 'include':
                        $code .= $this->file($arg[1] . '/' . $arg[2] . '.php');
                        break;

                    default:
                        $code .= $this->file($arg[1] . '/' . $arg[2] . '.php');
                        break;
                }
                return $code;
            default:
                break;
        }
        return $this->file($file);
    }

}

?>