<?php

namespace Jdjiwi\Ajax;

use Jdjiwi\JScript,
    Jdjiwi\Debug;

class Response {

    private $arScript = null;
    private $arHtml = null;
    private $arHtmlLog = array();

    public function log() {
        return array(
            'ajax-result' => '',
            'script' => $this->arScript,
            'html' => $this->arHtmlLog
        );
    }

    public function result() {
        $result = array();
        if (!empty($this->arScript)) {
            $result['script'] = $this->arScript;
        }
        if (!empty($this->arHtml)) {
            $result['html'] = $this->arHtml;
        }
        return $result;
    }

    /* === адреса === */

    public function hash($hash) {
        return $this->script("document.location.hash = '{$hash}';");
    }

    public function redirect($u) {
        $this->script("core.redirect('{$u}');");
        exit;
    }

    public function reload() {
        $this->script("core.reload();");
        exit;
    }

    /* === /адреса === */



    /* === скрипты === */

    public function script($js) {
        $this->arScript .= PHP_EOL . $js;
        return $this;
    }

    // alert
    public function alert($content) {
        return $this->script('alert("' . JScript::quote($content) . '");');
    }

    /* === /скрипты === */



    /* === html === */

    public function htmlId($id, $content) {
        return $this->html('#' . $id, $content);
    }

    public function html($id, $content) {
        if ($id !== '#ajax-content' and Debug::isAjax()) {
            $this->arHtmlLog[$id] = $content;
        }
        $this->arHtml[] = array(
            'selected' => $id,
            'content' => $content
        );
        return $this;
    }

    /* === /html === */



    /* === пользовательские скрипты === */

    public function assign() {
        if (func_num_args() < 3)
            return;

        $d = func_get_args();
        $k = JScript::quote(array_shift($d));
        $v = JScript::quote(array_pop($d));
        $js = "cmf.getId('$k')";

        reset($d);
        while (list(, $v2) = each($d)) {
            $js .= '.' . $v2;
        }
        $js .= " = '$v'";

        return $this->script($js);
    }

    /* === /пользовательские скрипты === */
}
