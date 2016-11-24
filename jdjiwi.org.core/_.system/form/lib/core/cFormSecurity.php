<?php

use Jdjiwi\Session,
    Jdjiwi\JScript;

class cFormSecurity extends cFormCore {

    // проверка
    protected function is() {
//        return 0;
        return $this->form()->settings()->security;
    }

    public function isValid() {
        if ($this->is()) {
            $this->value(); // баг
            if ($is = \Jdjiwi\Input::post()->get($this->key()) !== $this->value()) {
                $this->error()->setSecurity(
                        $this->config()->error()->security
                );
            }
            $this->reset();
            return !$is;
        }
        return true;
    }

    // ключи
    protected function key() {
        return $this->form()->hash('security-key');
    }

    // обновление ключа
    protected function reset() {
        Session::set($this->key(), time());
    }

    // значение
    protected function value($salt = '') {
        return $this->form()->hash($salt . 'security-value' . Session::get($this->key()));
    }

    // показ, и обновление формы
    public function viewStart() {
        $this->reset();
        ?><input id="<?= $this->key() ?>" name="<?= $this->key() ?>" class="<?= $this->parent()->name('security') ?>" type="hidden" value="<?= $this->value('noValid') ?>"/><?
    }

    public function viewEnd() {
        if ($this->form()->settings()->security) {
            ?><script><?= $this->js() ?></script><?
        }
    }

    public function update() {
        if ($this->form()->settings()->security) {
            \Jdjiwi\Ajax::get()->script($this->js());
        }
    }

    protected function js() {
        return JScript::encode(
                        JScript::queryClass($this->form()->name('security'))
                                ->attr(array('id' => $this->key(), 'name' => $this->key()))
                                ->val($this->value())
        );
    }

}
