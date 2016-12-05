<?php

namespace Jdjiwi\Form;

use Jdjiwi\JScript,
    Jdjiwi\Ajax;

class cFormError extends Core {

    private $arError = array();

    public function set($key, $value) {
        $this->arError[$key] = $value;
    }

    public function setSecurity($value) {
        $this->set('form-security', $value);
    }

    public function is() {
        return (bool) $this->arError;
    }

    public function clear() {
        $this->arError = array();
    }

    public function errorId() {
        return $this->form()->name('error');
    }

    public function view() {
        ?><p class="formError" id="<?= $this->errorId() ?>"><?= $this->parent()->config()->error()->submit ?></p><?
    }

    public function update() {
        $mHidden = array();
        foreach ($this->form()->all() as $name => $el) {
            if (isset($this->arError[$name])) {
                if ($el->settings()->isErrorHide) {
                    $mHidden[] = $this->arError[$name];
                    Jdjiwi\Ajax::get()->script('cForm.error.color.show("' . $el->id() . '", "' . $this->form()->settings()->color . '");');
                } else {
                    Jdjiwi\Ajax::get()->script('cForm.error.show("' . $el->id() . '", "' . $el->errorId() . '", "' . $this->form()->settings()->color . '", "' . JScript::quote($this->arError[$name]) . '");');
                }
                unset($this->arError[$name]);
            } else {
                Jdjiwi\Ajax::get()->script('cForm.error.hide("' . $el->id() . '", "' . $el->errorId() . '");');
            }
        }
        if (!empty($mHidden)) {
            Jdjiwi\Ajax::get()->script('cForm.error.alert("' . JScript::quote($this->config()->error()->form) . '", "' . JScript::quote(implode('<br>', $mHidden)) . '");');
        }
        if (isset($this->arError[$name = 'form-security'])) {
            Jdjiwi\Ajax::get()->script('cForm.error.alert("' . JScript::quote($this->arError[$name = 'form-security']) . '");');
            unset($this->arError[$name]);
        }
        if (empty($this->arError)) {
            Jdjiwi\Ajax::get()->script(
                    JScript::queryId($this->errorId())->hide()
            );
        } else {
            Jdjiwi\Ajax::get()->script(
                    JScript::queryId($this->errorId())->html(implode('<br>', $this->arError))->show()
            );
        }
        $this->clear();
    }

}
