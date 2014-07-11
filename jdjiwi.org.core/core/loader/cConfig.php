<?php

class cConfig {

    static private $mComfig = array();
    static private $mData = array();

    static public function pre() {
        echo '<pre>';
        print_r(self::$mComfig);
        print_r(self::$mData);
        echo '</pre>';
    }

    static public function __callStatic($name, $arguments) {
        switch (count($arguments)) {
            case 0:
                if (empty(self::$mComfig[$name])) {
                    self::$mComfig[$name] = new cConfigData();
                }
                return self::$mComfig[$name];
                break;
            case 1:
                self::$mData[$name] = $arguments[0];
                break;

            default:
                self::$mData[$name] = $arguments;
                break;
        }
    }

}

class cConfigData {

    private $mComfig = array();
    private $mData = array();

    public function __get($value) {
        return isset($this->mData[$value]) ? $this->mData[$value] : null;
    }

    public function __call($name, $arguments) {
        switch (count($arguments)) {
            case 0:
                if (empty($this->mComfig[$name])) {
                    $this->mComfig[$name] = new self();
                }
                return $this->mComfig[$name];
                break;
            case 1:
                $this->mData[$name] = $arguments[0];
                break;

            default:
                $this->mData[$name] = $arguments;
                break;
        }
    }

}

?>