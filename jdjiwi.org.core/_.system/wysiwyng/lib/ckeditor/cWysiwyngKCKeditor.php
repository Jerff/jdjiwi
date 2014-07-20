<?php
cLoader::library('wysiwyng:cWysiwyngDriver');

class cWysiwyngKCKeditor extends cWysiwyngDriver {

    public function html($model, $id, $inputId, $value, $height = null) {
        $filemanager = cConfig::get('filemanager.app.url');
        $saltId = $this->getSaltId();
        $salt = $this->createSalt();

        cHeader::addJs(cConfig::get('kckeditor.app.url') . 'ckeditor.js');
        cHeader::addJs(cConfig::get('kckeditor.app.url') . 'adapters/jquery.js');
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
        $value = cJScript::quote($value);
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
?>