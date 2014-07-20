<?php

cLoader::library('wysiwyng:cWysiwyngDriver');

class cWysiwyngDriver {

    //abstract static public function html($path, $number, $id, $value);
    //abstract static public function getJsSetData($id, $value);

    public function getPath($path, $number) {
        if (!$path or ! $number)
            exit;

        $_map = cWysiwyngConfig::getMap();
        var_dump($_map);
        if (!isset($_map[$path]))
            exit;
        $controller = $_map[$path];
        if (is_array($controller)) {
            $path = $controller[0];
            $controller = $controller[1];
        } else
            $path = path_wysiwyng . $path . '/';


        $controller = cLoader::initModul($controller);
        cAccess::isWrite($controller);

        if (!$controller->wysiwyngIsRecord($number))
            exit;

        if (!$path)
            exit;
        $path = $path . $number . '/';
        $filePath = cWWWPath . $path;
        $wwwPath = '/' . $path;
        return array($wwwPath, $filePath);
    }

    public function addRecord($path, $number) {
        /* if(!$path or !$number) return;
          $path = cWWWPath . $path;
          if(!cmfDir::isDir($path)) {
          if(!cmfDir::newDir($path)) return;
          }
          $path .= $number .'/';
          if(!cmfDir::isDir($path)) {
          if(!cmfDir::newDir($path)) return;
          } */
    }

    public function delRecord($path, $number) {
        if (!$path or ! $number)
            return;
        $path = cWWWPath . $path . $number . '/';
        cDir::clear($path, true);
    }

    public function recordPath($modul) {
        $_map = cWysiwyngConfig::getMap();
        while ((list($k, $v) = each($_map))) {
            if (is_string($v)) {
                if ($modul === $v)
                    return path_wysiwyng . $k . '/';
            } else {
                if ($modul === $v[1]) {
                    return $v[0];
                }
            }
        }
        return false;
    }

}

?>