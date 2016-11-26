<?php

namespace Jdjiwi\FileSystem\Image;

use Jdjiwi\Shell;

class ImageMagick {

    const logo = 'logo.png';

    static public function isOn() {
        return Config::get('image.ImageMagick.is');
    }

    static public function createLogo($size, $notice) {
        $notice = addslashes($notice);
        $path = cWWWPath . path_watermark;
        $logo = $path . self::logo;
        Shell::exec($com = self::command('convert') . " -size 400x100 xc:grey30 -font Arial -pointsize $size -gravity center  -draw \"fill grey70  text 0,0  '{$notice}'\" {$path}stamp_fgnd.png");
        Shell::exec($com = self::command('convert') . " -size 400x100 xc:black -font Arial -pointsize $size -gravity center  -draw \"fill white  text  1,1  '{$notice}' text  0,0  '{$notice}' fill black  text -1,-1 '{$notice}'\" +matte {$path}stamp_mask.png");
        Shell::exec($com = self::command('composite') . " -compose CopyOpacity {$path}stamp_mask.png {$path}stamp_fgnd.png {$logo}");
        Shell::exec($com = self::command('mogrify') . " -trim +repage {$logo}");
    }

    static public function watermark($image) {
        $place = Settings::read('watermark', 'place');
        $type = Settings::read('watermark', 'type');
        if ($type === 'text') {
            $logo = cWWWPath . path_watermark . Image::logo;
        } else {
            $logo = cWWWPath . path_watermark . Settings::read('watermark', 'image');
        }
        list($wLogom, $hLogo) = getimagesize($logo);
        list($wImage, $hImage) = getimagesize($image);
        if ($wLogom > ($hLogo * .7)) {
            $wLogo = ceil($wImage * .7);
            $hLogo = ceil($hImage * .7);
            $tmp = tempnam(cWWWPath . path_watermark, 'watermark');
            copy($logo, $tmp);
            Image::resize($tmp, $wLogo, $hLogo);
            $logo = $tmp;
        }
        Shell::exec(self::command('composite') . " -gravity {$place} -geometry +10+10 {$logo} {$image} {$image}");
    }

    static public function resize($image, $width, $height) {
        exec($com = self::command('mogrify') . " -resize {$width}x{$height} $image");
    }

    static public function thumbnail($small, $oWidth, $oHeight, $x1, $y1, $w, $h, $width, $height) {
        Shell::exec($com = self::command('convert') . " -size {$oWidth}x{$oHeight} {$small} -crop {$w}x{$h}+{$x1}+{$y1} -auto-orient +repage {$small}");
        //echo '<br />'. $com;
        //exec($com = self::command('convert') ." -size {$oWidth}x{$oHeight} {$small} -thumbnail {$oWidth}x{$oHeight} -gravity center -crop {$x1}x{$y1}+{$w}+{$h} -auto-orient +repage {$small}");
        //exec($com = self::command('convert') ." -size {$oWidth}x{$oHeight} {$small} -thumbnail {$oWidth}x{$oHeight} -gravity center -crop {$x1}x{$y1}+{$w}+{$h} -auto-orient +repage {$small}");
        Shell::exec($com = self::command('mogrify') . " -resize {$width}x{$height} $small");
        //echo '<br />'. $com;
    }

}
