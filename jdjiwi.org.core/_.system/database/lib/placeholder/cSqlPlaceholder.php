<?php

cLoader::library('database:registry/cDatabaseRegistry');

class cDatabasePlaceholder extends cDatabaseRegistry {

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
        return $this->DB()->bilder()->query($query);
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
                        $str .= $sep . $t . $this->DB()->quoteParam($k) . ' AS ' . $v;
                    else
                        $str .= $sep . $t . $this->DB()->quoteParam($v);
                    $sep = ', ';
                }
                return $str;

            case 'field':
                return $this->DB()->quoteParam($a);

            case 's':
                return addslashes($a);

            case 'like':
                return '%' . addslashes(str_replace('%', '%%', $a)) . '%';

            case 'i':
                return (int) $a;

            case 't':
                return $this->DB()->quoteParam($a);

            case 't%':
                $str = '';
                $sep = '';
                while (list($k, $v) = each($a)) {
                    $str .= $sep . $this->DB()->quoteParam($v);
                    $sep = ', ';
                }
                return $str;


            case '@':
                if (!count($a))
                    return 'IN(-1)';
                $str = '';
                $sep = '';
                while (list($k, $v) = each($a)) {
                    $str .= $sep . $this->DB()->quoteString($v);
                    $sep = ', ';
                }
                return 'IN(' . $str . ')';

            case '%':
                $str = '';
                $sep = '';
                while (list($k, $v) = each($a)) {
                    $str .= $sep . $this->DB()->quoteParam($k) . '=' . $this->DB()->quoteString($v);
                    $sep = ', ';
                }
                return $str;

            case 'w':
                while (list($k, $v) = each($a))
                    if (is_array($v)) {
                        if (count($v)) {
                            while (list($k2, $v2) = each($v))
                                $v[$k2] = $this->DB()->quoteString($v2);
                            $v = 'IN(' . implode(', ', $v) . ')';
                        } else
                            $v = 'IN(-1)';

                        $a[$k] = $t . $this->DB()->quoteParam($k) . ' ' . $v;
                    } elseif (is_string($k))
                        $a[$k] = $t . $this->DB()->quoteParam($k) . '=' . $this->DB()->quoteString($v);
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
                        $a[$k] = $t . $this->DB()->quoteParam($v);
                }
                return implode(', ', $a);


            default:
                return $this->DB()->quoteString($a);
        }
    }

}
