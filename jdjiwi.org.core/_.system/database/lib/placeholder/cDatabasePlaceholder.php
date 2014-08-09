<?php

class cDatabasePlaceholder {

    private $args = null;
    private $arg = null;

    private function &getArgs() {
        return $this->args[$this->arg++];
    }

    public function query() {
        $args = func_get_args();
        $query = (string) array_shift($args);

        $this->arg = 0;
        $this->args = $a;
        $query = preg_replace_callback('~\?([^\:\s]*)\:([^\s\,\'\"]*)|\?(fields|field|function|t\%|[^\s\,\'\"\)]?)~S', array(&$this, 'run'), $query);
        $this->args = null;
        return cDB::bilder()->query($query);
    }

    private function run($m) {
        if (isset($m[3])) {
            $c = $m[3];
            $t = '';
        } else {
            $c = $m[1];
            $t = $m[2] . '.';
        }
        unset($m);

        $a = $this->getArgs();
        switch ($c) {
            case 'f':
            case 'function':
                $str = '';
                $sep = '';
                while (list($k, $v) = each($a)) {
                    if (is_string($k))
                        $str .= $sep . $k . ' AS ' . $v;
                    else
                        $str .= $sep . $v;
                    $sep = ', ';
                }
                return $str;

            case 'fields':
                $str = '';
                $sep = '';
                while (list($k, $v) = each($a)) {
                    if (is_string($k))
                        $str .= $sep . $t . cDB::quote()->param($k) . ' AS ' . $v;
                    else
                        $str .= $sep . $t . cDB::quote()->param($v);
                    $sep = ', ';
                }
                return $str;

            case 'field':
                return cDB::quote()->param($a);

            case 's':
                return addslashes($a);

            case 'like':
                return '%' . addslashes(str_replace('%', '%%', $a)) . '%';

            case 'i':
                return (int) $a;

            case 't':
                return cDB::quote()->param($a);

            case 't%':
                $str = '';
                $sep = '';
                while (list($k, $v) = each($a)) {
                    $str .= $sep . cDB::quote()->param($v);
                    $sep = ', ';
                }
                return $str;


            case '@':
                if (!count($a))
                    return 'IN(-1)';
                $str = '';
                $sep = '';
                while (list($k, $v) = each($a)) {
                    $str .= $sep . cDB::quote()->string($v);
                    $sep = ', ';
                }
                return 'IN(' . $str . ')';

            case '%':
                $str = '';
                $sep = '';
                while (list($k, $v) = each($a)) {
                    $str .= $sep . cDB::quote()->param($k) . '=' . cDB::quote()->string($v);
                    $sep = ', ';
                }
                return $str;

            case 'w':
                while (list($k, $v) = each($a))
                    if (is_array($v)) {
                        if (count($v)) {
                            while (list($k2, $v2) = each($v))
                                $v[$k2] = cDB::quote()->string($v2);
                            $v = 'IN(' . implode(', ', $v) . ')';
                        } else
                            $v = 'IN(-1)';

                        $a[$k] = $t . cDB::quote()->param($k) . ' ' . $v;
                    } elseif (is_string($k))
                        $a[$k] = $t . cDB::quote()->param($k) . '=' . cDB::quote()->string($v);
                    else
                        $a[$k] = (string) $v;

                return implode(' ', $a);

            case 'o':
                while (list($k, $v) = each($a)) {
                    if ($k === 'function') {
                        $a[$k] = $v;
                    } else
                    if (is_string($k))
                        $a[$k] = $t . $k . ' ' . $v;
                    else
                        $a[$k] = $t . cDB::quote()->param($v);
                }
                return implode(', ', $a);


            default:
                return cDB::quote()->string($a);
        }
    }

}
