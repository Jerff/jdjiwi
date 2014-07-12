<?php

cConfig::load('crypt');

class cCrypt {

    static public function crc32($n) {
        return crc32($n) & 0xffffffff;
    }

    static public function sha1($n) {
        return sha1($n);
    }

    static public function hash() {
        $n = serialize(func_get_args());
        return self::sha1(cSalt . $n) . self::crc32(cSalt . $n);
    }

    static public function password($password) {
        return crypt($password, cSalt);
    }

}

?>