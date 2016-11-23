<?php

namespace Jdjiwi\Wysiwyng;

use Jdjiwi\Loader,
    Jdjiwi\Config,
    Jdjiwi\Header,
    Jdjiwi\JScript;

Loader::library('wysiwyng:Driver');

class KCKeditor extends Driver {

    public function html($model, $id, $inputId, $value, $height = null) {
        $filemanager = Config::get('filemanager.app.url');
        $saltId = $this->getSaltId();
        $salt = $this->createSalt();

        Header::addJs(Config::get('kckeditor.app.url') . 'ckeditor.js');
        Header::addJs(Config::get('kckeditor.app.url') . 'adapters/jquery.js');
        $html = <<<HTML
<script type="text/javascript">
    jQuery(function() {
        jQuery('#{$inputId}').ckeditor({
            external_filemanager_path:"{$filemanager}",
            filemanager_title:"Responsive Filemanager" ,
            external_plugins: { "filemanager" : "{$filemanager}plugin.min.js"}
            filemanager_access_key:"{$salt}",
        });
    });
</script>
<input type="hidden" name="{$saltId}" value="{$salt}">
HTML;
        return $html;
    }

    public function jsUpdate($id, $value) {
        $value = JScript::quote($value);
        $js = <<<HTML
CKEDITOR.Instances.{$id}.setData('$value');
HTML;
        return $js;
    }

    public function typograf($id) {
        ?>
        <br>
        <div title="ТипограF" style="padding: 5px;">
            <a id="typograf<?= $id ?>" href="<?= self::getJsPath() ?>editor/plugins/typograf/typograf2.html?id=<?= $id ?>">
                <img src="<?= self::getJsPath() ?>editor/plugins/typograf/typograf.gif" class="TB_Button_Image">
            </a>
            <script type="text/javascript">
                $("#typograf<?= $id ?>").fancybox({type: 'iframe'});
            </script>
        </div>
        <?
    }

}
