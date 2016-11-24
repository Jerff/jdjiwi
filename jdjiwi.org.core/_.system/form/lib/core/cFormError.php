<?php

use Jdjiwi\JScript;

class cFormError extends cFormCore {

    private $mError = array();

    public function set($key, $value) {
        $this->mError[$key] = $value;
    }

    public function setSecurity($value) {
        $this->set('form-security', $value);
    }

    public function is() {
        return (bool) $this->mError;
    }

    public function clear() {
        $this->mError = array();
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
            if (isset($this->mError[$name])) {
                if ($el->settings()->isErrorHide) {
                    $mHidden[] = $this->mError[$name];
                    \Jdjiwi\Ajax::get()->script('cForm.error.color.show("' . $el->id() . '", "' . $this->form()->settings()->color . '");');
                } else {
                    \Jdjiwi\Ajax::get()->script('cForm.error.show("' . $el->id() . '", "' . $el->errorId() . '", "' . $this->form()->settings()->color . '", "' . JScript::quote($this->mError[$name]) . '");');
                }
                unset($this->mError[$name]);
            } else {
                \Jdjiwi\Ajax::get()->script('cForm.error.hide("' . $el->id() . '", "' . $el->errorId() . '");');
            }
        }
        if (!empty($mHidden)) {
            \Jdjiwi\Ajax::get()->script('cForm.error.alert("' . JScript::quote($this->config()->error()->form) . '", "' . JScript::quote(implode('<br>', $mHidden)) . '");');
        }
        if (isset($this->mError[$name = 'form-security'])) {
            \Jdjiwi\Ajax::get()->script('cForm.error.alert("' . JScript::quote($this->mError[$name = 'form-security']) . '");');
            unset($this->mError[$name]);
        }
        if (empty($this->mError)) {
            \Jdjiwi\Ajax::get()->script(
                    JScript::queryId($this->errorId())->hide()
            );
        } else {
            \Jdjiwi\Ajax::get()->script(
                    JScript::queryId($this->errorId())->html(implode('<br>', $this->mError))->show()
            );
        }
        $this->clear();
    }

}
