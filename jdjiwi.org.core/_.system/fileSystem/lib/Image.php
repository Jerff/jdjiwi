<?php

namespace Jdjiwi\FileSystem;

use Jdjiwi\Settings,
    Jdjiwi\Config,
    Jdjiwi\Loader;

Config::load('image');
//Loader::library('fileSystem:image/ImageMagick');
//Loader::library('fileSystem:image/Watermark');

class Image {

    static public function resize($image, $width, $height) {
        if (!file_exists($image))
            return false;
        $size = getimagesize($image);
        if ($size === false)
            return false;

        // Определяем исходный формат по MIME-информации, предоставленной
        // функцией getimagesize, и выбираем соответствующую формату
        // imagecreatefrom-функцию.
        $img_x = $size[0];
        $img_y = $size[1];
        if (is_array($width) or is_array($height)) {
            $width = get($width, 'max');
            $height = get($height, 'max');

            if ($img_x < $width and $img_y < $height)
                return;
        }

        if ($width === null or $width > $img_x)
            $width = $img_x;
        if ($height === null) {
            $height = $img_y / ($img_x / $width);
        }
        if ($height === null or $height > $img_y)
            $height = $img_y;
        if ($width === $img_x and $height === $img_y)
            return true;

        if (ImageMagick::isOn()) {
            ImageMagick::resize($image, $width, $height);
//            Shell::exec($com = self::command('mogrify') . " -resize {$width}x{$height} $image");
            //pre($com);
            return;
        } else {

            $quality = 100;   // качество сжатия
            $rgb = 0xFFFFFF; // цвет фона

            $format = strtolower(substr($size['mime'], strpos($size['mime'], '/') + 1));
            $icfunc = "imagecreatefrom" . $format;
            if (!function_exists($icfunc))
                return false;

            $x_ratio = $width / $img_x;
            $y_ratio = $height / $img_y;

            $ratio = min($x_ratio, $y_ratio);
            // координаты разные
            $use_x_ratio = ($x_ratio == $ratio);

            $new_width = $use_x_ratio ? $width : floor($img_x * $ratio);
            $new_height = !$use_x_ratio ? $height : floor($img_y * $ratio);
            $new_left = $use_x_ratio ? 0 : floor(($width - $new_width) / 2);
            $new_top = !$use_x_ratio ? 0 : floor(($height - $new_height) / 2);


            $image_in = $icfunc($image);
            $image_out = imagecreatetruecolor($new_width, $new_height);

            imagefill($image_out, 0, 0, $rgb);
            imagecopyresampled($image_out, $image_in, 0, 0, 0, 0, $new_width, $new_height, $img_x, $img_y);
            imagedestroy($image_in);

            $icfunc = "image" . $format;
            $icfunc($image_out, $image, $quality);
            imagedestroy($image_out);
            return true;
        }
    }

    static public function thumbnail($small, $oWidth, $oHeight, $x1, $y1, $w, $h, $width, $height) {
        if (ImageMagick::isOn()) {
            ImageMagick::thumbnail($small, $oWidth, $oHeight, $x1, $y1, $w, $h, $width, $height);
        }
    }

}
