<?php

use Jdjiwi\JScript;

\Jdjiwi\Loader::library('form:element/cFormText');
\Jdjiwi\Loader::library('form:element/cFormEmail');
\Jdjiwi\Loader::library('form:element/cFormPassword');
\Jdjiwi\Loader::library('form:element/cFormNumber');
\Jdjiwi\Loader::library('form:element/cFormInt');
\Jdjiwi\Loader::library('form:element/cFormFloat');
\Jdjiwi\Loader::library('form:element/cFormRange');

//\Jdjiwi\Loader::library('form:element/cmfFormText');
//\Jdjiwi\Loader::library('form:element/cmfFormKcaptcha');
//\Jdjiwi\Loader::library('form:element/cmfFormPassword');
//\Jdjiwi\Loader::library('form:element/cmfFormTextarea');
//\Jdjiwi\Loader::library('form:element/cmfFormCheckbox');
//\Jdjiwi\Loader::library('form:element/cmfFormSelect');
//\Jdjiwi\Loader::library('form:element/cmfFormRadio');
//\Jdjiwi\Loader::library('form:element/cmfFormFile');
//\Jdjiwi\Loader::library('form:element/cmfFormImage');

\Jdjiwi\Loader::library('form:core/cFormElementReform');
\Jdjiwi\Loader::library('form:core/cFormElementFilter');
\Jdjiwi\Loader::library('form:library/cFormReform');
\Jdjiwi\Loader::library('form:library/cFormFilter');

abstract class cFormElement extends cFormCore {

    // настройки
    public function settings() {
        return $this->register('cFormSettings');
    }

    // преобразование значений
    public function reform() {
//        $this->isInit();
        return $this->register('cFormElementReform');
    }

    // преобразование значений
    public function filter() {
//        $this->isInit();
        return $this->register('cFormElementFilter');
    }

    // инициализация элемента
//    private function isInit() {
//        static $is = false;
//        if (!$is) {
//            $is = true;
//            $this->init();
//        }
//    }
    // инициализация элемента
    public function init() {
        
    }

    /* === управление данными === */

    private $value = null;

    // очистка данных фотмы
    public function clear() {
        $this->value = null;
    }

    // вернуть значения
    public function get() {
        return $this->value;
    }

    // вернуть значения формы - при пустом показываем значение по умолчанию
    public function value() {
        return $this->reform()->view($this->get());
//        return $this->value ? $this->reform()->view($this->value) : $this->settings()->default;
    }

    // установить значения
    public function set($value) {
        $this->value = $value;
    }

    // значение элемента не изменено со значения по умолчанию
    public function isDefault($value) {
        return $value == $this->settings()->default;
    }

    // переопередеоение свойств формы
    public function reset() {
        $this->clear();
    }

    /* === /управление данными === */



    /* === старое значение === */

    // id старого значение
    public function oldId() {
        return $this->form()->name('old' . $this->id());
    }

    /* === старое значение === */



    /* === идентификация === */

    // id ошибки
    public function errorId() {
        return $this->form()->name('error' . $this->id());
    }

    // идентификатор
    public function id() {
        return $this->form()->name('id') . '-' . $this->name();
    }

    // имя формы
    public function name() {
        return $this->settings()->id;
    }

    /* === /идентификация === */



    /* шаблоны */

    public function template() {
        static $mTemplate = false;
        if ($mTemplate === false) {
            $mTemplate = array();
            foreach (cDir::getFiles(\Jdjiwi\Config::get('path.app.form') . \Jdjiwi\Config::get('form.templates')) as $file) {
                $name = \Jdjiwi\Str::substr(basename($file), -4);
                $mTemplate[$name] = str_replace(cSoursePath, '', $file);
            }
        }
        $class = get_class($this) . 'Html';
        if (isset($mTemplate[$class])) {
            \Jdjiwi\Loader::library($mTemplate[$class]);
        } else {
            \Jdjiwi\Loader::library('form:template/' . \Jdjiwi\Config::get('form.templates') . '/' . $class);
        }
        return $this->register($class);
    }

    public function error($attr = '') {
        $this->template()->error($this);
    }

    public function html($attr = '') {
        $this->template()->input($this, $attr);
        $this->template()->old($this);
    }

    /* === /шаблоны === */



    /* === обработка данных === */

    public function handler($isChange = false) {
        return $this->processing($isChange, false);
    }

    public function processing($isChange = true, $isUpload = true) {
        $value = \Jdjiwi\Input\Post::get($this->id());
        if ($this->isDefault($value)) {
            $value = null;
        }
        $value = $this->reform()->data($value);
        $this->filter()->start($value);

        if ($isChange) {
            if ($value == \Jdjiwi\Input\Post::get($this->oldId()))
                return null;
//            if($value===$this->getOld()) return null;
//            else if($value==$this->getOld()) return null;
        } else {
            if (is_null($value)) {
                $value = '';
            }
        }
        $this->set($value);
        return $value;
    }

    /* === /обработка данных === */



    /* === обновление данных === */

    public function update($isOldUpdate = true) {
        $this->template()->js($this, $isOldUpdate);
//        if ($isOldUpdate) {
//            cAjax::get()->script(
//                    JScript::queryId($this->oldId())->val($this->get())
//            );
//        }
//        cAjax::get()->script(
//                JScript::queryId($this->id())->val($this->value())
//        );
    }

    /* === /обновление данных === */
}
