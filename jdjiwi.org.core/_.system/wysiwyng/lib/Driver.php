<?php

namespace Jdjiwi\Wysiwyng;

use Jdjiwi\Loader,
    \Jdjiwi\Config,
    Jdjiwi\Crypt;

abstract class Driver {

    static public function getSalt() {
        return Config::get('wysiwyng.salt');
    }

    public function createSalt($model, $id) {
        static $salt = array();
        if (empty($salt[$model][$id])) {
            if (empty($id)) {
                $id = 't' . Crypt::hash($model, time(), rand(0, 100));
            }
            $data = array(
                'model' => $model,
                'id' => $id,
                'salt' => $this->getSalt()
            );
            $salt[$model][$id] = base64_encode(cConvert::serialize($data));
        }
        return $salt[$model][$id];
    }

    protected function parserParam($data) {
        $data = cConvert::unserialize(base64_decode($data));
        if (empty($data['model']) or empty($data['id']) or empty($data['salt'])) {
            return false;
        }
        if ($data['salt'] !== $this->getSalt()) {
            return false;
        };
        return $data;
    }

    public function getTmpId($model, $id) {
        $data = $this->parserParam(cInput::post()->get($this->getSaltId($model, $id)));
        if (empty($data)) {
            return false;
        }
        return $data['id'];
    }

    protected function getSaltId($model, $id) {
        return Crypt::hash(__CLASS__, $model, $id);
    }

    abstract static public function html($model, $id, $inputId, $value, $height = null);

    abstract static public function jsUpdate($id, $value);

    public function getPath() {
        $param = $this->parserParam(cInput::get()->get(Config::get('filemanager.app.key')));
        if (empty($param)) {
            die('Access Denied!');
        }
        cInput::get()->set(Config::get('filemanager.app.key'), $this->getSalt());

        $model = cModel::init($param['model']);
        cAccess::isWrite($param['model']);
        if (!$model->wysiwyngIsRecord($param['id'])) {
            die('Access Denied!');
        }

        $path = $model->getWysiwyngPath();
        if ($param['id']{0} === 't') {
            $path = Config::get('file.path.tmp') . $param['id'] . '/';
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
