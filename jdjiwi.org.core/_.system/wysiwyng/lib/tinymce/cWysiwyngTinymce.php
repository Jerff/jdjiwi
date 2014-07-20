<?php

cLoader::library('wysiwyng:cWysiwyngDriver');

class cWysiwyngTinymce extends cWysiwyngDriver {

    public function html($model, $id, $inputId, $value, $height = null) {
        $filemanager = cConfig::get('filemanager.app.url');
        $saltId = self::getSaltId();
        $salt = self::createSalt();

//        cHeader::addJs('http://code.jquery.com/jquery-2.1.0.min.js');
        cHeader::addJs(cConfig::get('tinymce.app.url') . 'tinymce.min.js');
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
            height: 180,
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
        $value = cJScript::quote($value);
        $js = <<<HTML

HTML;
        return $js;
    }

}

?>