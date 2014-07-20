<?php

cLoader::library('wysiwyng:cWysiwyngDriver');

abstract class cWysiwyngDriver {

    public function createSalt($model, $id) {
        static $salt = null;
        if (empty($salt)) {
            if (empty($id)) {
                $id = 't' . cCrypt::hash($model, time(), rand(0, 100));
            }
            $data = array(
                'model' => $model,
                'id' => $id,
                'salt' => cConfig::get('wysiwyng.salt')
            );
            $salt = base64_encode(cConvert::serialize($data));
        }
        return $salt;
    }

    public function parseParam() {
        return cConvert::unserialize(base64_decode(cInput::post()->get(self::getSaltId())));
    }

    public function getTmpId($model, $id) {
        $data = $this->parseParam();
        if (isset($data['id'])) {
            return $data['id'];
        } else {
            return false;
        }
    }

    protected function getSaltId($model, $id) {
        return cCrypt::hash(__CLASS__, $model, $id);
    }

    abstract static public function html($model, $id, $inputId, $value, $height = null);

    abstract static public function jsUpdate($id, $value);

    public function getPath() {
        $param = $this->parseParam();
        if (empty($param['model']) or empty($param['id']) {
            die('Access Denied!');
        }

        $model = cModel::init($param['model']);
        cAccess::isWrite($param['model']);
        if (!$model->wysiwyngIsRecord($param['id'])) {
            die('Access Denied!');
        }

        $path = $model->getWysiwyngPath();
        if ($param['id']{0} === 't') {
            $path = cConfig::get('file.path.tmp') . $param['id'] . '/';
        } else {
            $path .= $param['id'] . '/';
        }
        $filePath = cWWWPath . $path;
        $wwwPath = '/' . $path;
        return array($wwwPath, $filePath);
    }

    public function addRecord($model, $id) {
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

    public function delRecord($model, $id) {
        if (empty($model) or empty($id))
            return;
        cFileSystem::rmdir(cWWWPath . $path . $number . '/', true);
    }

}

?>