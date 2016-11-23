<?php

namespace Jdjiwi\Wysiwyng;

use Jdjiwi\Loader,
    Jdjiwi\Config,
    Jdjiwi\Header,
    Jdjiwi\JScript;

Loader::library('wysiwyng:Driver');

class Tinymce extends Driver {

    public function html($model, $id, $inputId, $value, $height = 180) {
        $filemanager = Config::get('filemanager.app.url');
        $saltId = $this->getSaltId();
        $salt = $this->createSalt();

        Header::addJs(Config::get('tinymce.app.url') . 'tinymce.min.js');
        $html = <<<HTML
<script type="text/javascript">
    jQuery(function() {
        jQuery('#{$inputId}').tinymce({
            plugins: [
                "advlist autolink lists link image charmap print preview anchor",
                "searchreplace visualblocks code fullscreen",
                "insertdatetime media table contextmenu paste responsivefilemanager"
            ],
            toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
            autosave_ask_before_unload: false,
            max_height: 200,
            min_height: 160,
            height: {$height},
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

HTML;
        return $js;
    }

}
