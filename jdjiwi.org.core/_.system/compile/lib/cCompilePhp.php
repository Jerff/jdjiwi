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
        cFileSystem::mkdir(dirname($compile));
        file_put_contents($compile, $this->compile($file, true));
        return $compile;
    }

    /*
     * update
     */

    public function updateLoader() {
        file_put_contents(
                cConfig::get('compile.path') . cCompile::config()->loaderPhp(), cCompile::php()->compile(cSoursePath . cCompile::config()->loaderPhp())
        );
        foreach (cDir::getFolders(cConfig::get('compile.path')) as $path) {
            cFileSystem::rmdir($path, true);
        }
    }

    private $mFile = null;
    private $item = null;
    private $isLoad = null;

    public function compile($files, $isLoad = false) {
        $this->mFile = array();
        $this->isLoad = $isLoad;
        $content = '';
        foreach ((array) $files as $file)
            $content .= $this->file($file);
        $content = preg_replace('#\?>\s*<\?php#S', ' ', $content);
        $content = preg_replace('#\n\s*#Sm', "\n", $content);

        $content = str_replace("\r", '', $content);
        return $content;
    }

    private function file($file) {
        if (isset($this->mFile[$file]))
            return '';
        $this->item = $file;
        $this->mFile[$file] = true;

        $content = cString::convertEncoding(php_strip_whitespace($file));
        $content = preg_replace_callback("#(\".*?\")|('.*?')|(\{.*?\})|((require|require_once|include|include_once)\('(.*?)'\);)#sS", array(&$this, 'includeFile'), $content);
        $content = preg_replace_callback("#(\".*?\")|('.*?')|(\{.*?\})|((cLoader::library|cConfig::load|cModul::load|cModul::config)\('(.*?)'\);)#sS", array(&$this, 'loadFile'), $content);

        $content = "<?php\n#include $file\n?>" . $content . "<?php\n#end $file\n?>";

        return $content;
    }

    private function includeFile($m) {
        if (!isset($m[6]))
            return $m[0];
        return ' ?>' . $this->file($m[6]) . '<?php ';
    }

    private function loadFile($m) {
        if (isset($m[6])) {
            switch ($m[5]) {
                case 'cLoader::library':
                    $m[6] = str_replace(':', '/lib/', $m[6]);
                    return 'cLoader::setHistory(\'' . $m[6] . '\');' .
                            ' ?>' . $this->file($m[6] . '.php') . '<?php ';

                case 'cConfig::load':
                    $code = '';
                    foreach (cConfig::getFiles($m[6]) as $file) {
                        $code .= 'cConfig::set(\'' . $m[6] . '\', \'' . $file . '\', function(){ ?>' . file_get_contents(cConfig::path($file)) . '<?php });';
                    }
                    return $code;

                case 'cModul::load':
                    return 'cModul::setHistory(\'' . $m[6] . '\', \'include\');' .
                            ' ?>' . $this->file($m[6] . '/include.php') . '<?php ';

                case 'cModul::call':
                    return 'cModul::setHistory(\'' . $m[6] . '\', \'call\');' .
                            ' ?>' . $this->file($m[6] . '/call.php') . '<?php ';

                case 'cModul::config':
                    return ' ?>' . $this->file($m[6] . '/config/' . $m[6] . '.php') . '<?php ';

                default:
                    break;
            }
        }
        return $m[0];
    }

}

?>
