<?php

namespace Jdjiwi\FileSystem\Image;

use Jdjiwi\Settings,
    Jdjiwi\Config,
    Jdjiwi\FileSystem\Image\ImageMagick;

class Watermark {

    static public function createLogo($size, $notice) {
        if (ImageMagick::isOn()) {
            ImageMagick::createLogo($size, $notice);
        }
    }

    static public function run($image) {
        if (ImageMagick::isOn()) {
            ImageMagick::watermark($size, $notice);
        }
    }

}
