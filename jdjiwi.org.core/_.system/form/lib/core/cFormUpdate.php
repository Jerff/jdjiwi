<?php

use Jdjiwi\Form\Core;

class cFormUpdate extends Core {

    public function js($isOldUpdate = true) {
        $this->security()->update();
        $this->error()->update();
        foreach ($this->form()->all() as $el) {
            $el->update($isOldUpdate);
        }
    }

}
