<?php

cLoader::library('core:string/cConvert');

class cString {

    static public function init() {
        cConfig::load('i18n');
        setlocale(LC_ALL, cConfig::get('i18n.locale'));
        if (extension_loaded('mbstring')) {
            mb_language(cConfig::get('i18n.mbstring.language'));
            mb_internal_encoding(cConfig::get('i18n.charset'));
        }
    }

    static public function convertEncoding($str) {
        $char = mb_detect_encoding($str);
        if ($char !== cConfig::get('i18n.charset')) {
            $str = mb_convert_encoding($str, cConfig::get('i18n.charset'));
        }
        return $str;
    }

    static public function strlen($str) {
        return mb_strlen($str, cConfig::get('i18n.charset'));
    }

    static public function strpos($haystack, $needle, $offset = 0) {
        return mb_strpos($haystack, $needle, $offset, cConfig::get('i18n.charset'));
    }

    static public function strrpos($haystack, $needle, $offset = 0) {
        return mb_strrpos($haystack, $needle, $offset, cConfig::get('i18n.charset'));
    }

    static public function substr($str, $start, $len = 0) {
        return mb_substr($str, $start, $len, cConfig::get('i18n.charset'));
    }

    static public function replace($search, $replace, $subject) {
        return str_replace($search, $replace, $subject);
    }

    static public function strtolower($str) {
        return mb_strtolower($str, cConfig::get('i18n.charset'));
    }

    static public function strtoupper($str) {
        return mb_strtoupper($str, cConfig::get('i18n.charset'));
    }

    static public function firstToUpper($str) {
        return ucfirst($str);
//        return mb_strtoupper(self::substr($str, 0, 1), cConfig::get('i18n.charset')) . self::substr($str, 1, self::strlen($str) - 1);
    }

    //cConvert::specialchars(
    //cString::specialchars(
    static public function specialchars($str) {
        return htmlspecialchars(trim($str), ENT_QUOTES, cConfig::get('i18n.charset'));
    }

    //cConvert::specialchars(
    //cString::specialchars(
    function entityDecode($str) {
        return html_entity_decode($str, ENT_QUOTES, cConfig::get('i18n.charset'));
    }

    //cConvert::trim(
    //cString::trim(
    static public function trim($value) {
        if (is_array($value)) {
            return array_map('self::trim', $value);
        } else {
            return trim($value);
        }
    }

    //cConvert::subContent(
    //cString::subContent(
    static public function subContent($content, $pos0 = 0, $select_len = 300) {
        $select_len -= 4;

        $content = strip_tags($content);
        $point1 = $pos0;
        $content_len = cString::strlen($content);
        if ($content_len <= $select_len)
            return $content;
        $select_count = 2;
        if ($point1 > 0) {
            if (($point1 - $select_len) > 0) {
                $content_start = cString::substr($content, $point1 - $select_len, $select_len);
                $end_pos = 0;
                $i = $select_count;
                while ($i--) {
                    $point0 = cString::substr($content_start, '?', $end_pos);
                    $tmp_pos = cString::substr($content_start, '!', $end_pos);
                    if ($tmp_pos > $point0)
                        $point0 = $tmp_pos;
                    $tmp_pos = cString::substr($content_start, '.', $end_pos);
                    if ($tmp_pos > $point0)
                        $point0 = $tmp_pos;
                    $end_pos = $point0 - $select_len - 1;
                }
                if ($point0 === false) {
                    $point0 = 0;
                    while ($point0 < $point1 && $content_start[$point0] != ' ')
                        $point0++;
                    $content_start = '... ' . cString::substr($content_start, $point0 + 1);
                } else
                    $content_start = cString::substr($content_start, $point0 + 1);
            } else
                $content_start = cString::substr($content, 0, $point1);
        } else
            $content_start = cString::substr($content, 0, $point1);

        if ($point1 + $select_len < $content_len) {
            $content_end = cString::substr($content, $point1, $select_len);
            $i = $select_count;
            $end_pos = $select_len / 2;
            while ($i--) {
                $point0 = cString::strrpos($content_end, '?', $end_pos);

                $tmp_pos = cString::strrpos($content_end, '!', $end_pos);
                if ($point0 === false or ( $tmp_pos < $point0 and $tmp_pos !== false))
                    $point0 = $tmp_pos;
                $tmp_pos = cString::strrpos($content_end, '.', $end_pos);
                if ($point0 === false or ( $tmp_pos < $point0 and $tmp_pos !== false))
                    $point0 = $tmp_pos;
                if ($point0 === false)
                    break;
                $end_pos = $point0 + 1;
            }
            if ($point0 === false) {
                $point0 = $select_len - 1;
                while ($point0 && $content_end[$point0] != ' ')
                    $point0--;
                $content_end = cString::substr($content_end, 0, $point0) . ' ...';
            } else
                $content_end = cString::substr($content_end, 0, $point0 + 1);
        } else
            $content_end = cString::substr($content, $point1);
        return $content_start . $content_end;
    }

}

?>