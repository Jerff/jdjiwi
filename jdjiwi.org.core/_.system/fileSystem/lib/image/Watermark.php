<?php

namespace Jdjiwi\FileSystem\Image;

use Jdjiwi\Settings,
    Jdjiwi\Config,
    Jdjiwi\FileSystem\Image\ImageMagick;

class Watermark {

    static public function getPath($file = '') {
        return cWWWPath . path_watermark;
    }

    static public function createLogo($size, $notice) {
        if (ImageMagick::isOn()) {
            ImageMagick::createLogo(Config::get('image.watermark.logo'), $size, $notice);
        }
    }

    static public function run($image) {
        if (ImageMagick::isOn()) {
            ImageMagick::watermark($size, $notice);
        }
    }

}
